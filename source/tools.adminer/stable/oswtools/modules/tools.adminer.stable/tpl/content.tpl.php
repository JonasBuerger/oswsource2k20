<?php

/**
 * This file is part of the osWFrame package
 *
 * @author Juergen Schwind
 * @copyright Copyright (c) JBS New Media GmbH - Juergen Schwind (https://jbs-newmedia.com)
 * @package osWFrame
 * @link https://oswframe.com
 * @license MIT License
 */

?>

<?php if (in_array(\osWFrame\Core\Settings::getAction(), ['about'])): ?>

	<?php include \osWFrame\Core\Settings::getStringVar('settings_abspath').'resources'.DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.'about.tpl.php'; ?>

<?php elseif (in_array(\osWFrame\Core\Settings::getAction(), ['changelog'])): ?>

	<?php include \osWFrame\Core\Settings::getStringVar('settings_abspath').'resources'.DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.'changelog.tpl.php'; ?>

<?php else: ?>

	<iframe src="<?php echo $this->buildhrefLink('current', 'action=adminer')?>" class="iframe" name="info" seamless="" frameBorder="0"></iframe>

<?php endif ?>