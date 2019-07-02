<?php


namespace components;

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
     * Возвращает строку запроса
     * @return string
     */
    private function getUri()
    {
        return !empty($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '/') : null;
    }

    /**
     * Вызывает запрашиваемый энш
     */
    public function run()
    {
        # получаем строку запроса
        $uri = !empty($this->getUri()) ? $this->getUri() : '/';

        foreach ($this->routes as $uriPattern => $path) {
            # проверяем наличие такого запроса в маршрутах
            if (preg_match("~{$uriPattern}~", $uri)) {
                # получаем внутренний путь из внешнего согласно правилу
                $internalRoute = preg_replace("~{$uriPattern}~", $path, $uri);
                # разбиваем в массив
                $segments = explode('/', $internalRoute);
                # получаем имя контроллера
                $controllerName = ucfirst(array_shift($segments) . 'Controller');
                # получаем имя экшена
                $actionName = 'action' . ucfirst(array_shift($segments));
                # остальное это параметры
                $parameters = $segments;
                # формируем имя класса
                $className = '\controllers\\' . $controllerName;
                # создаем объект контроллера
                $controllerObject = new $className();
                # вызываем экшн
                $result = call_user_func_array([$controllerObject, $actionName], $parameters);

                if ($result != null) {
                    break;
                }
            }
        }
    }
}
