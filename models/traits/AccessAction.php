<?php


namespace models\traits;


use system\core\App;

trait AccessAction
{
    public function checkAction($view)
    {
        if (App::$components->session->isGuest() && !empty($this->authAction)) {
            foreach ($this->authAction as $action) {
                $this->check($view, $action);
            }
        } elseif (!empty($this->guestAction)) {
            foreach ($this->guestAction as $action) {
                $this->check($view, $action);
            }
        }
    }

    private function check($view, $action)
    {
        if ($view == $action) {
            $referer = App::$components->request->referer;
            return header("Location: {$referer}");
        }
    }
}
