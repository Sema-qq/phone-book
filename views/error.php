<?php
/**
 * @var \system\core\Controller $this
 * @var string $message
 */

use extensions\HtmlHelper;
?>
<?= $message ? HtmlHelper::alerts('danger', $message) : null ?>
<?= HtmlHelper::getImage('404.jpg'); ?>
