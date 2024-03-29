<?php


namespace system\core;

use models\traits\AccessAction;

/**
 * Базовый класс контроллер
 */
class Controller
{
    use AccessAction;

    /** @var string Путь к представлениям */
    const VIEW_FOLDER = 'views/';
    /** @var string Путь к лейаутам */
    const LAYOUT_FOLDER = 'views/layouts/';

    /** @var string Дефолтный экшн */
    public $defaultAction = 'index';
    /** @var array Экшны на которые можно только авторизованныем пользователям */
    public $authAction = [];
    /** @var array Экшны на которые можно только гостям */
    public $guestAction = [];
    /** @var string Дефолтный лейаут */
    protected $layout = 'main';

    /** @var string Представление */
    private $_view;
    /** @var array Данные для представления */
    private $_data;

    /**
     * Возвращает 404
     * @param string $message
     * @return mixed
     */
    public function showError($message = null, $exit = false)
    {
        $this->render('error', compact('message'));

        if ($exit) {
            exit();
        }
    }

    /**
     * Возвращает представление с лейаутами
     * @param string $view путь к представлению
     * @param array $data данные, для передачи в представление
     * @return mixed
     */
    public function render($view, $data = [])
    {
        $this->checkAction($view);
        $this->_view = $view;
        $this->_data = $data;
        return $this->getLayout();
    }

    /**
     * Возвращает представление без лейаутов
     * @param string $view путь к представлению
     * @param array $data данные, для передачи в представление
     * @return false|string
     */
    public function renderPartial($view, $data)
    {
        $this->checkAction($view);
        $this->_view = $view;
        $this->_data = $data;
        echo $this->getContent();
    }

    /**
     * Перенаправляет на указанный экшн
     * @param string $view маршрут, куда перенаправлять
     */
    public function redirect($view)
    {
        $this->checkAction($view);
        return header("Location: {$view}");
    }

    /**
     * Возвращает контент: представление.
     * @return false|string
     */
    protected function getContent()
    {
        ob_start();

        $this->getView();

        return ob_get_clean();
    }

    /**
     * Подключает css файл
     * @param string $templatePath путь до файла
     * @return string
     */
    public function registerCssFile($templatePath)
    {
        echo "<link href='{$templatePath}' rel='stylesheet'>";
    }

    /**
     * Подключает js файл
     * @param string $templatePath путь до файла
     * @return string
     */
    public function registerJsFile($templatePath)
    {
        echo "<script src='{$templatePath}' type='text/javascript'></script>";
    }

    /**
     * Отрисовывает представление
     * @return mixed
     */
    private function getView()
    {
        extract($this->_data);

        return require $this->getViewFolder() . "/{$this->_view}.php";
    }

    /**
     * Возвращает папку с вьюхами дочернего контроллера
     * @return string
     */
    private function getViewFolder()
    {
        $dir = $this->_view == 'error' ? null : $this->getChildClassName();
        return ROOT . self::VIEW_FOLDER . $dir;
    }

    /**
     * Отрисовывает леайут
     * @return mixed
     */
    private function getLayout()
    {
        return require ROOT .self::LAYOUT_FOLDER . $this->layout . '.php';
    }

    /**
     * Возвращает имя дочернего контроллера
     * @return string
     */
    private function getChildClassName()
    {
        return strtolower(str_replace(['controllers\\', 'Controller', 'system\core\\'], '', get_class($this)));
    }
}
