<?php


namespace system\core;


class Session
{
    private $session;

    public function __construct()
    {
        $this->session = &$_SESSION;
    }

    public function get($key)
    {
        return isset($this->session[$key]) ? $this->session[$key] : null;
    }

    public function set($key, $value)
    {
        $this->session[$key] = $value;
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
        if (isset($this->session['user'])) {
            unset($this->session['user']);
        }
    }
}
