<?php

/**
 * This file is part of the osWFrame package
 *
 * @author Juergen Schwind
 * @copyright Copyright (c) JBS New Media GmbH - Juergen Schwind (https://jbs-newmedia.com)
 * @package osWFrame
 * @link https://oswframe.com
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License 3
 */

if (strlen($this->getDoSendElementStorage($element))>0) {
	$database_where_string='';
	$ddm_filter_array=$this->getGroupOption('filter', 'database');
	if (!empty($ddm_filter_array)) {
		$ddm_filter=[];
		foreach ($ddm_filter_array as $filter_data) {
			$ar_values=[];
			foreach ($filter_data as $filter_logic=>$filter_elements) {
				foreach ($filter_elements as $filter_element) {
					$ar_values[]=$this->getGroupOption('alias', 'database').'.'.$filter_element['key'].$filter_element['operator'].$filter_element['value'];
				}
			}
			$ddm_filter[]='('.implode(' '.strtoupper($filter_logic).' ', $ar_values).')';
		}
		$database_where_string.=' AND ('.implode(' OR ', $ddm_filter).')';
	}

	$QcheckData=self::getConnection();
	$QcheckData->prepare('SELECT :formdata_name: FROM :table: AS :alias: WHERE :formdata_name: LIKE :value: :where:');
	$QcheckData->bindTable(':table:', $this->getGroupOption('table', 'database'));
	$QcheckData->bindRaw(':alias:', $this->getGroupOption('alias', 'database'));
	$QcheckData->bindRaw(':formdata_name:', $this->getGroupOption('alias', 'database').'.'.$this->getSendElementValue($element, 'name'));
	$QcheckData->bindString(':value:', $this->getDoSendElementStorage($element));
	$QcheckData->bindRaw(':where:', $database_where_string);
	if ($QcheckData->exec()>0) {
		$this->getTemplate()->Form()->addErrorMessage($element, osWFrame\Core\StringFunctions::parseTextWithVars($this->getGroupMessage('validation_element_unique'), $this->getFilterElementStorage($element)));
		$this->setFilterErrorElementStorage($element, true);
	}
}

?>