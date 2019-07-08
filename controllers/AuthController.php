<?php


namespace controllers;


use models\LoginForm;
use models\SignupForm;
use models\User;
use system\core\App;
use system\core\Controller;

/**
 * Контроллер для авторизации и регистрации
 */
class AuthController extends Controller
{
    /** @var string Дефолтный экшн */
    public $defaultAction = 'login';

    /**
     * Авторизация
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        
        if (App::$components->request->isPost()) {
            $model->load(App::$components->request->post);
            if ($model->validate()) {
                App::$components->session->login($model->getUser());
                return $this->redirect('/');
            }
            dd($model);
        }
        
        return $this->render('login', compact('model'));
    }

    /**
     * Регистрация
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if (App::$components->request->isPost()) {
            $model->load(App::$components->request->post);
            if ($model->save()) {
                return $this->redirect('/');
            }
        }

        return $this->render('signup', compact('model'));
    }

    /**
     * Логаут
     */
    public function actionLogout()
    {
        App::$components->session->logout();
        return $this->redirect('/');
    }
}
