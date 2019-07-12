<?php
/**
 * @var \system\core\Controller $this
 * @var string $message
 */

use extensions\HtmlHelper;
?>
<?= HtmlHelper::alerts('danger', $message); ?>
<?= HtmlHelper::getImage('404.jpg'); ?>
