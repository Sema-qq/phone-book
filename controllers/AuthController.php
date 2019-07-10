<?php


namespace controllers;


use models\LoginForm;
use models\SignupForm;
use system\core\App;
use system\core\Controller;

/**
 * Контроллер для авторизации и регистрации
 */
class AuthController extends Controller
{
    public $defaultAction = 'login';
    public $authAction = ['logout'];
    public $guestAction = ['login', 'signup'];

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
                return $this->redirect('/contact');
            }
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
                App::$components->session->login($model->getUser());
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
