<?php


namespace controllers;


use system\core\App;
use system\core\Controller;

/**
 * Контроллер сайта
 */
class SiteController extends Controller
{
    /**
     * Cтартовая страница
     */
    public function actionIndex()
    {
        if (!App::$components->session->isGuest()) {
            $this->redirect('/contact/index');
        }

        return $this->render('index');
    }
}
