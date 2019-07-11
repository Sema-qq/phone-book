<?php


namespace controllers;


use models\Contact;
use models\ImageUpload;
use system\core\App;
use system\core\Controller;

class ContactController extends Controller
{
    public $authAction = ['index', 'create', 'update', 'view', 'set-image', 'setImage'];

    public function actionIndex()
    {
        $sort = App::$components->request->get('sort');

        $sort = $sort && is_string($sort) && property_exists(Contact::class, $sort) ? [$sort => 'ASC'] : [];

        $contacts = Contact::getAllContactsByUser(App::$components->user->ID, $sort);

        return $this->render('index', compact('contacts'));
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

        return $this->render('create', compact('model'));
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

        return $this->render('update', compact('model'));
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);

        return $this->render('view', compact('model'));
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

            dd($filename);
        }

        return $this->render('set-image', compact('model', 'image'));
    }

    /**
     * Возвращает объект Контакта
     * @param int $id
     * @return Contact
     * @throws \Exception
     */
    private function loadModel($id)
    {
        if ($model = Contact::findOne($id)) {
            return $model;
        }

        throw new \Exception("Контакт №{$id} не найден");
    }
}
