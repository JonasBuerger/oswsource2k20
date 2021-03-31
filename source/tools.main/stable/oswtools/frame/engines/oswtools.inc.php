<?php

/**
 * This file is part of the VIS2 package
 *
 * @author Juergen Schwind
 * @copyright Copyright (c) JBS New Media GmbH - Juergen Schwind (https://jbs-newmedia.com)
 * @package VIS2
 * @link https://oswframe.com
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License 3
 */

$osW_Template=new \osWFrame\Core\Template();

\osWFrame\Core\Settings::setStringVar('settings_framepath', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR);

/**
 * Jquery3
 */
$jsfiles=['resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'jquery.min.js'];
$osW_Template->addTemplateJSFiles('head', $jsfiles);

/**
 * Jquery3 - Easing
 */
$jsfiles=['resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'jquery.easing.min.js'];
$osW_Template->addTemplateJSFiles('head', $jsfiles);

/**
 * Bootstrap4
 */
$jsfiles=['resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'bootstrap.bundle.min.js'];
#$cssfiles=['resources'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'bootstrap-oswtools.min.css'];
$cssfiles=['resources'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'bootstrap.min.css'];
$osW_Template->addTemplateJSFiles('head', $jsfiles);
$osW_Template->addTemplateCSSFiles('head', $cssfiles);

/**
 * Bootstrap4 - Datatables
 */
$jsfiles=['resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'jquery.dataTables.min.js', 'resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'dataTables.bootstrap4.min.js', 'resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'dataTables.responsive.min.js'];
$cssfiles=['resources'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'dataTables.bootstrap4.min.css', 'resources'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'responsive.bootstrap4.min.css'];
$osW_Template->addTemplateJSFiles('head', $jsfiles);
$osW_Template->addTemplateCSSFiles('head', $cssfiles);

/**
 * Bootstrap4 - Select
 */
$jsfiles=['resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'bootstrap-select.min.js'];
$cssfiles=['resources'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'bootstrap-select.min.css'];
$osW_Template->addTemplateJSFiles('head', $jsfiles);
$osW_Template->addTemplateCSSFiles('head', $cssfiles);

/**
 * Bootstrap4 - bootbox
 */
$jsfiles=['resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'bootbox.all.min.js'];
$osW_Template->addTemplateJSFiles('head', $jsfiles);

/**
 * FontAwesome5
 */
$jsfiles=['resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'fontawesome.min.js'];
$cssfiles=['resources'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'fontawesome.min.css'];
$osW_Template->addTemplateJSFiles('head', $jsfiles);
$osW_Template->addTemplateCSSFiles('head', $cssfiles);

/**
 * osWTools
 */
$jsfiles=['resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'oswtools.js'];
$cssfiles=['resources'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'oswtools.css'];
$osW_Template->addTemplateJSFiles('head', $jsfiles);
$osW_Template->addTemplateCSSFiles('head', $cssfiles);

\osWFrame\Core\Network::sendHeader('Content-Type: text/html; charset=utf-8');
$osW_Template->addVoidTag('base', ['href'=>\osWFrame\Core\Settings::getStringVar('project_domain_full')]);
$osW_Template->addVoidTag('meta', ['charset'=>'utf-8']);
$osW_Template->addVoidTag('meta', ['http-equiv'=>'X-UA-Compatible', 'content'=>'IE=edge']);
$osW_Template->addVoidTag('meta', ['name'=>'viewport', 'content'=>'width=device-width, initial-scale=1, shrink-to-fit=no']);
$osW_Template->addVoidTag('base', ['rel'=>'shortcut icon', 'href'=>\osWFrame\Core\Settings::getStringVar('project_domain_full').'favicon.ico']);

\osWFrame\Core\Settings::setStringVar('frame_current_module', \osWFrame\Core\Settings::getStringVar('frame_default_module'));

if (\osWFrame\Core\Settings::getStringVar('frame_current_module')==\osWFrame\Core\Settings::getStringVar('project_default_module')) {
	\osWFrame\Core\Settings::setStringVar('frame_current_module', 'tools.main.stable');;
}

\osWFrame\Tools\Helper::setDoAction(\osWFrame\Core\Settings::catchValue('doaction', '', 'pg'));

$file=\osWFrame\Core\Settings::getStringVar('settings_abspath').'modules'.DIRECTORY_SEPARATOR.\osWFrame\Core\Settings::getStringVar('frame_current_module').DIRECTORY_SEPARATOR.'php'.DIRECTORY_SEPARATOR.'content.inc.php';
if (file_exists($file)) {
	include_once $file;
	$osW_Template->setVarFromFile('content', 'content', \osWFrame\Core\Settings::getStringVar('frame_current_module'), 'modules');

	\osWFrame\Core\Navigation::checkUrl();

	$osW_Template->addStringTag('title', $Tool->getActionName(\osWFrame\Core\Settings::getAction()).' - osWTools:'.$Tool->getStringValue('name'));
} else {
	\osWFrame\Core\Settings::setStringVar('frame_current_module', \osWFrame\Core\Settings::getStringVar('errorlogger_module'));
	$_GET['error_status']=404;
	\osWFrame\Core\Settings::setStringVar('frame_default_engine', 'errorlogger');
	\osWFrame\Core\Settings::setStringVar('frame_default_output', 'errorlogger');

	$file=\osWFrame\Core\Settings::getStringVar('settings_abspath').'modules'.DIRECTORY_SEPARATOR.\osWFrame\Core\Settings::getStringVar('frame_current_module').DIRECTORY_SEPARATOR.'php'.DIRECTORY_SEPARATOR.'content.inc.php';
	if (file_exists($file)) {
		include_once $file;
	}
}

?>