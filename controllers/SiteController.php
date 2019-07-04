<?php


namespace controllers;


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
        return $this->render('index');
    }
}
