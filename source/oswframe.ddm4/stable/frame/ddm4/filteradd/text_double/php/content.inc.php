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

$this->setDoAddElementStorage($element.'_double', osWFrame\Core\Settings::catchValue($element.'_double', '', 'p'));

if ($this->getDoAddElementStorage($element)!=$this->getDoAddElementStorage($element.'_double')) {
	$this->getTemplate()->Form()->addErrorMessage($element.'_double', osWFrame\Core\StringFunctions::parseTextWithVars($this->getGroupMessage('validation_element_double'), $this->getFilterElementStorage($element)));
	$this->setFilterErrorElementStorage($element, true);
}

?>