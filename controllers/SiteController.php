<?php


namespace controllers;


use system\core\Controller;

/**
 * Контроллер сайта
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionError()
    {
        return $this->render('error');
    }
}
