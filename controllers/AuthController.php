<?php


namespace controllers;


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
        $this->render('login', ['test' => 1]);
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
