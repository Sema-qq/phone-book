<?php


namespace system\core;

/**
 * Маршрутизатор
 */
class Router
{
    /** @var array Массив с маршрутами */
    private $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routes = require ROOT . 'config/routes.php';
    }

    /**
     * Вызывает запрашиваемый энш
     */
    public function run()
    {
        $uri = $this->getUri();

        # сначала перебираем роуты
        foreach ($this->routes as $uriPattern => $path) {
            # проверяем наличие такого запроса в маршрутах
            if (preg_match("~{$uriPattern}~", '/')) {
                # получаем внутренний путь из внешнего согласно правилу
                $internalRoute = preg_replace("~{$uriPattern}~", $path, $uri);
                if ($this->callAction($internalRoute)) {
                    return true;
                }
            }
        }

        # если в роутах нет, пробуем найти урлу контроллер и экшн: /controllerName/actionName/params
        if ($this->callAction($uri)) {
            return true;
        }

        # если экшн не нашли, то покажем 404
        $controller = new Controller();
        return $controller->showError();
    }

    /**
     * Возвращает строку запроса
     * @return string
     */
    private function getUri()
    {
        $uri = !empty($_SERVER['REQUEST_URI']) ? strtok(trim($_SERVER['REQUEST_URI'], '/'), '?') : null;
        return $uri ? $uri : '/';
    }

    /**
     * Вызывает экшн
     * @param string $string Строка поиска имени контроллера и экшн с параметрами
     * @return bool|mixed
     */
    private function callAction($string)
    {
        # разбиваем в массив
        $segments = explode('/', $string);
        # получаем имя контроллера
        $controllerName = ucfirst(array_shift($segments) . 'Controller');
        # получаем имя экшена
        $actionName = 'action' . ucfirst(array_shift($segments));
        # остальное это параметры
        $parameters = $segments;
        # формируем имя класса
        $className = '\controllers\\' . $controllerName;
        if (class_exists($className)) {
            $controller = new $className();
            # если такого метода нет и экшн не был указан, то обратимся к дефолтному экшену
            if (!method_exists($controller, $actionName) && $actionName == 'action') {
                $actionName = 'action' . ucfirst($controller->defaultAction);
            }
            # еще раз проверяем, существует ли такой метод
            if (method_exists($controller, $actionName)) {
                # вызываем экшн
                call_user_func_array([$controller, $actionName], $parameters);
                return true;
            }
        }
        return false;
    }
}
