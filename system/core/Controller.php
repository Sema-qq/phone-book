<?php


namespace system\core;

/**
 * Базовый класс контроллер
 */
class Controller
{
    /** @var string Путь к представлениям */
    const VIEW_FOLDER = ROOT . 'views/';
    /** @var string Путь к лейаутам */
    const LAYOUT_FOLDER = ROOT . 'views/layouts/';

    /** @var string Дефолтный экшн */
    public $defaultAction = 'index';

    /** @var string Дефолтный лейаут */
    protected $layout = 'main';

    /** @var string Представление */
    private $view;
    /** @var array Данные для представления */
    private $data;

    /**
     * Возвращает 404
     * @return mixed
     */
    public function showError()
    {
        return $this->render('error');
    }

    /**
     * Возвращает представление с лейаутами
     * @param string $view путь к представлению
     * @param array $data данные, для передачи в представление
     * @return mixed
     */
    protected function render($view, $data = [])
    {
        $this->view = $view;
        $this->data = $data;
        return $this->getLayout();
    }

    /**
     * Возвращает представление без лейаутов
     * @param string $view путь к представлению
     * @param array $data данные, для передачи в представление
     * @return false|string
     */
    protected function renderPartial($view, $data)
    {
        $this->view = $view;
        $this->data = $data;
        return $this->getContent();
    }

    /**
     * Перенаправляет на указанный экшн
     * @param string $view маршрут, куда перенаправлять
     */
    protected function redirect($view)
    {
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
    protected function registerCssFile($templatePath)
    {
        return "<link href='{$templatePath}' rel='stylesheet'>";
    }

    /**
     * Подключает js файл
     * @param string $templatePath путь до файла
     * @return string
     */
    protected function registerJsFile($templatePath)
    {
        return "<script src='{$templatePath}' type='text/javascript'></script>";
    }

    /**
     * Отрисовывает представление
     * @return mixed
     */
    private function getView()
    {
        extract($this->data);

        return require $this->getViewFolder() . "/{$this->view}.php";
    }

    /**
     * Возвращает папку с вьюхами дочернего контроллера
     * @return string
     */
    private function getViewFolder()
    {
        return self::VIEW_FOLDER . $this->getChildClassName();
    }

    /**
     * Отрисовывает леайут
     * @return mixed
     */
    private function getLayout()
    {
        return require self::LAYOUT_FOLDER . $this->layout . '.php';
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
