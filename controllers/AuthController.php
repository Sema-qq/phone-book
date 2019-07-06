<?php


namespace controllers;


use models\LoginForm;
use system\core\Application;
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
        
        if (Application::$components->session->isPost())
        
        $this->render('login', compact('model'));
    }

    /**
     * Регистрация
     */
    public function actionSignup()
    {
        $this->render('signup', ['test' => 1]);
    }

    /**
     * Логаут
     */
    public function actionLogout()
    {
        # разлогиниваем пользователя
    }
}
