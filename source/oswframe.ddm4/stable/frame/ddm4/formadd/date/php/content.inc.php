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

$date=[];
$date['day']=[];
$date['day']['00']='';
for ($i=1; $i<=31; $i++) {
	$date['day'][sprintf('%02d', $i)]=sprintf('%02d', $i);
}

$date['month']=[];
$date['month']['00']='';
for ($i=1; $i<=12; $i++) {
	if ($this->getAddElementOption($element, 'month_asname')===true) {
		$date['month'][sprintf('%02d', $i)]=\osWFrame\Core\DateTime::strftime('%B', mktime(12, 0, 0, $i, 01, 2000));
	} else {
		$date['month'][sprintf('%02d', $i)]=sprintf('%02d', $i);
	}
}

$date['year']=[];
$date['year']['0000']='';
if ($this->getAddElementOption($element, 'year_sortorder')=='desc') {
	for ($i=$this->getAddElementOption($element, 'year_max'); $i>=$this->getAddElementOption($element, 'year_min'); $i--) {
		$date['year'][sprintf('%02d', $i)]=sprintf('%02d', $i);
	}
} else {
	for ($i=$this->getAddElementOption($element, 'year_min'); $i<=$this->getAddElementOption($element, 'year_max'); $i++) {
		$date['year'][sprintf('%02d', $i)]=sprintf('%02d', $i);
	}
}

$this->setAddElementOption($element, 'data', $date);

if (\osWFrame\Core\Settings::getAction()=='doadd') {
	$this->setDoAddElementStorage($element, sprintf('%02d', osWFrame\Core\Settings::catchValue($element.'_year', '', 'p')).sprintf('%02d', osWFrame\Core\Settings::catchValue($element.'_month', '', 'p')).sprintf('%02d', osWFrame\Core\Settings::catchValue($element.'_day', '', 'p')));
}

$this->incCounter('form_elements');
$this->incCounter('form_elements_required');

?>