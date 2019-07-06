<?php


namespace system\core;


class Request
{
    private $get;
    private $post;
    private $server;
    private $files;

    public function __construct()
    {
        $this->get = &$_GET;
        $this->post = &$_POST;
        $this->server = &$_SERVER;
        $this->files = &$_FILES;
    }

    public function isPost()
    {
        return $this->server['REQUEST_METHOD'] === 'POST';
    }

    public function getPost($key = null)
    {
        if ($key) {
            return isset($this->post[$key]) ? $this->post[$key] : null;
        }
        return $this->post;
    }

    public function getGet($key = null)
    {
        if ($key) {
            return isset($this->get[$key]) ? $this->get[$key] : null;
        }
        return $this->get;
    }
}
