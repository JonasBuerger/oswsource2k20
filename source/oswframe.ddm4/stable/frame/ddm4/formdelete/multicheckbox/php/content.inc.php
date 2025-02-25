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

if (\osWFrame\Core\Settings::getAction()=='dodelete') {
	$multicheckbox=[];
	$data=$this->getDeleteElementOption($element, 'data');
	ksort($data);
	foreach ($data as $key=>$value) {
		$_value=\osWFrame\Core\Settings::catchValue($element.'_'.$key, 0, 'p');
		if ($_value==1) {
			$multicheckbox[]=$key;
		}
	}
	$this->setDoDeleteElementStorage($element, implode($this->getDeleteElementOption($element, 'separator'), $multicheckbox), 'string');
}

$this->incCounter('form_elements');
$this->incCounter('form_elements_required');

?>