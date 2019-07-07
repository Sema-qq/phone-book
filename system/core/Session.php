<?php


namespace system\core;


class Session extends BaseObject
{
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public function isGuest()
    {
        return !$this->get('user');
    }

    public function login($userObject)
    {
        $this->set('user', $userObject);
    }

    public function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
    }
}
