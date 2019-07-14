<?php


namespace controllers;


use models\Contact;
use models\Converter;
use models\ImageUpload;
use system\core\App;
use system\core\Controller;

class ContactController extends Controller
{
    public $authAction = ['index', 'create', 'update', 'view', 'set-image', 'setImage'];

    public function actionIndex()
    {
        $sortAttr = App::$components->request->get('sortAttr');
        $sort = App::$components->request->get('sort');

        if ($sortAttr &&
            $sort &&
            is_string($sort) &&
            in_array($sort, ['ASC', 'DESC']) &&
            property_exists(Contact::class, $sortAttr)
        ) {
            $sort = [$sortAttr => $sort];
        } else {
            $sort = [];
        }

        $contacts = Contact::getAllContactsByUser(App::$components->user->ID, $sort);

        return $this->callRender('index', compact('contacts'));
    }

    public function actionCreate()
    {
        $model = new Contact();

        if (App::$components->request->isPost()) {
            $model->load(App::$components->request->post());
            $model->USER_ID = App::$components->user->ID;

            if ($model->save()) {
                return $this->redirect("/contact/view/{$model->ID}");
            }
        }

        return $this->callRender('create', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (App::$components->request->isPost()) {
            $model->load(App::$components->request->post());

            if ($model->save()) {
                return $this->redirect("/contact/view/{$model->ID}");
            }
        }

        return $this->callRender('update', compact('model'));
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);

        return $this->callRender('view', compact('model'));
    }

    public function actionDelete($id)
    {
        // если будет время
    }

    public function actionSetImage($id)
    {
        $model = $this->loadModel($id);

        $image = new ImageUpload();

        if (App::$components->request->isPost()) {
            $image->load(App::$components->request->files('image'));

            if ($filename = $image->imageUpload($model->PHOTO)) {
                if ($model->saveImage($filename)) {
                    return $this->redirect("/contact/view/{$model->ID}");
                }
            }
        }

        return $this->callRender('set-image', compact('model', 'image'));
    }

    private function callRender($view, $data)
    {
        return App::$components->request->isAjax() ?
            $this->renderPartial($view, $data) : $this->render($view, $data);
    }

    /**
     * Возвращает объект Контакта
     * @param int $id
     * @return Contact
     * @throws \Exception
     */
    private function loadModel($id)
    {
        if ($model = Contact::find()
            ->where(['USER_ID' => App::$components->user->ID, 'ID' => $id])->one()
        ) {
            return $model;
        }

        return $this->showError('Не удалось найти контакт.', true);
    }
}
