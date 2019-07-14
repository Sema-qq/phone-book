<?php


namespace controllers;


use extensions\CaptchaHelper;
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

    /**
     * Капча
     */
    public function actionCaptcha()
    {
        # генерим код
        $text = CaptchaHelper::getText();
        # сохраняем в сессию
        App::$components->session->set('captcha', $text);
        # генерим картинку
        $img = CaptchaHelper::createImage($text, '/templates/fonts/Barriecito-Regular.ttf');
        # отправляем HTTP заголовки
        header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Content-type: image/gif");
        # выводим изображение в браузер
        imagegif($img);
        # Уничтожаем изображение
        imagedestroy($img);
    }
}
