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

<div class="form-group ddm_element_<?php echo $this->getSendElementValue($element, 'id') ?>">

	<?php /* label */ ?>
	<label class="form-label" for="<?php echo $element ?>"><?php echo \osWFrame\Core\HTML::outputString($this->getSendElementValue($element, 'title')) ?><?php if ($this->getSendElementOption($element, 'required')===true): ?><?php echo $this->getGroupMessage('form_title_required_icon') ?><?php endif ?><?php echo $this->getGroupMessage('form_title_closer') ?></label>

	<?php if ($this->getSendElementOption($element, 'read_only')===true): ?>

		<?php /* read only */ ?>
		<div class="form-control readonly" style="height:auto;"><?php echo \osWFrame\Core\HTML::outputString($this->getSendElementStorage($element)); ?></div>
		<?php echo $this->getTemplate()->Form()->drawHiddenField($element, $this->getSendElementStorage($element)) ?>

	<?php else: ?>

		<?php /* input */ ?>

		<?php echo $this->getTemplate()->Form()->drawTextareaField($element, $this->getSendElementStorage($element), ['input_class'=>'form-control', 'input_errorclass'=>'is-invalid']); ?>

	<?php endif ?>

	<?php /* error */ ?>
	<?php if ($this->getTemplate()->Form()->getErrorMessage($element)!==null): ?>
		<div class="text-danger small"><?php echo $this->getTemplate()->Form()->getErrorMessage($element) ?></div>
	<?php endif ?>

	<?php /* notice */ ?>
	<?php if ($this->getSendElementOption($element, 'notice')!=''): ?>
		<div class="text-info"><?php echo \osWFrame\Core\HTML::outputString($this->getSendElementOption($element, 'notice')) ?></div>
	<?php endif ?>

	<?php /* buttons */ ?>
	<?php if ($this->getSendElementOption($element, 'buttons')!=''): ?>
		<div>
			<?php echo implode(' ', $this->getSendElementOption($element, 'buttons')) ?>
		</div>
	<?php endif ?>

</div>