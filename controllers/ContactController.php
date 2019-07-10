<?php


namespace controllers;


use models\Contact;
use system\core\App;
use system\core\Controller;

class ContactController extends Controller
{
    public $authAction = ['index'];

    public function actionIndex()
    {
        $contacts = Contact::getAllContactsByUser(App::$components->session->user->ID);

        return $this->render('index', compact('contacts'));
    }
}
