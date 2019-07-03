<?php


namespace controllers;


use system\core\Controller;

/**
 * Контроллер для авторизации и регистрации
 */
class AuthController extends Controller
{
    public function actionLogin()
    {
        $this->render('login', ['test' => 1]);
    }

    public function actionSignup()
    {
        $this->render('signup', ['test' => 1]);
    }

    public function actionLogout()
    {
        # разлогиниваем пользователя
    }
}
