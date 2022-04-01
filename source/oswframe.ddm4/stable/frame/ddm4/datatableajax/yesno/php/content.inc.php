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

$datatableajax_rule='($("input[name=\''.$values['rule_key'].'\']:checked").val()=='.implode(' || $("input[name=\''.$values['rule_key'].'\']:checked").val()==', $values['rule_value']).')';
$this->setElementStorage('datatableajax_rule', $datatableajax_rule);

$datatableajax_selected='$("input[name=\''.$values['rule_key'].'\']").change(function(){ddm4formular_'.$this->getName().'();});';
$this->setElementStorage('datatableajax_selected', $datatableajax_selected);

?>