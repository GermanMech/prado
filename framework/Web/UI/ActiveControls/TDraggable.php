<?php
/**
 * TDraggable class file
 *
 * @author Christophe BOULAIN (Christophe.Boulain@gmail.com)
 * @copyright Copyright &copy; 2005-2016 The PRADO Group
 * @license https://github.com/pradosoft/prado/blob/master/LICENSE
 * @package Prado\Web\UI\ActiveControls
 */

namespace Prado\Web\UI\ActiveControls;
use Prado\TPropertyValue;
use Prado\Web\Javascripts\TJavaScript;
use Prado\Web\UI\WebControls\TPanel;

/**
 * TDraggable is a control which can be dragged
 *
 * Warning: this class is deprecatd and will be removed in a future release.
 * We suggest you to investigate using {@link TJuiDraggable} instead.
 *
 * This control will make "draggable" control.
 * Properties :
 *
 * <b>{@link setGhosting Ghosting}</b> : If set to "Ghosting" or "True", the dragged element will be cloned, and the clone will be dragged.
 * If set to "SuperGhosting", the element will be cloned, and attached to body, so it can be dragged outside of its parent.
 * If set to "None" of "False" (default), the element itself is dragged
 * <b>{@link setRevert Revert}</b>: Set to True if you want your dragged element to revert to its initial position if not dropped on a valid area.
 * <b>{@link setConstraint Constraint}</b>: Set this to Horizontal or Vertical if you want to constraint your move in one direction.
 * <b>{@link setHandle Handle}</b>:
 *
 * @author Christophe BOULAIN (Christophe.Boulain@gmail.com)
 * @copyright Copyright &copy; 2005-2016 The PRADO Group
 * @license https://github.com/pradosoft/prado/blob/master/LICENSE
 * @package Prado\Web\UI\ActiveControls
 * @deprecated Use TJuiDraggable instead
 */
class TDraggable extends TPanel
{
	/**
	 * Set the handle id or css class
	 * @param string
	 */
	public function setHandle ($value)
	{
		$this->setViewState('DragHandle', TPropertyValue::ensureString($value), null);
	}

	/**
	 * Get the handle id or css class
	 * @return string
	 */
	public function getHandle ()
	{
		return $this->getViewState('DragHandle', null);
	}

	/**
	 * Determine if draggable element should revert to it orginal position
	 * upon release in an non-droppable container.
	 * Since 3.2, Revert property can be set to one of the value of {@link TDraggableRevertOption} enumeration.
	 *   o 'True' or 'Revert' : The draggable will revert to it's original position
	 *   o 'False' or 'None' : The draggable won't revert to it's original position
	 *   o 'Failure' : The draggable will only revert if it's dropped on a non droppable area
	 * @return TDraggableRevertOption true to revert
	 */
	public function getRevert()
	{
		return $this->getViewState('Revert', TDraggableRevertOptions::Revert);
	}

	/**
	 * Sets whether the draggable element should revert to it orginal position
	 * upon release in an non-droppable container.
	 * Since 3.2, Revert property can be set to one of the value of {@link TDraggableRevertOption} enumeration.
	 *   o 'True' or 'Revert' : The draggable will revert to it's original position
	 *   o 'False' or 'None' : The draggable won't revert to it's original position
	 *   o 'Failure' : The draggable will only revert if it's dropped on a non droppable area
	 * @param boolean true to revert
	 */
	public function setRevert($value)
	{
		if (strcasecmp($value,'true')==0 || $value===true)
			$value=TDraggableRevertOptions::Revert;
		elseif (strcasecmp($value,'false')==0 || $value===false)
			$value=TDraggableRevertOptions::None;
		$this->setViewState('Revert', TPropertyValue::ensureEnum($value, 'Prado\\Web\\UI\\ActiveControls\\TDraggableRevertOptions'), true);
	}

	/**
	 * Determine if the element should be cloned when dragged
	 * If true, Clones the element and drags the clone, leaving the original in place until the clone is dropped.
	 * Defaults to false
	 * 	Since 3.2, Ghosting can be set to one of the value of {@link TDraggableGhostingOptions} enumeration.
	 *  o "True" or "Ghosting" means standard pre-3.2 ghosting mechanism
	 *  o "SuperGhosting" use the Superghosting patch by Christopher Williams, which allow elements to be dragged from an
	 *    scrollable list
	 *  o "False" or "None" means no Ghosting options
	 *
	 * @return TDraggableGhostingOption to clone the element
	 */
	public function getGhosting ()
	{
		return $this->getViewState('Ghosting', TDraggableGhostingOptions::None);
	}

	/**
	 * Sets wether the element should be cloned when dragged
	 * If true, Clones the element and drags the clone, leaving the original in place until the clone is dropped.
	 * Defaults to false
	 *
	 * Since 3.2, Ghosting can be set to one of the value of {@link TDraggableGhostingOptions} enumeration.
	 *  o "True" or "Ghosting" means standard pre-3.2 ghosting mechanism
	 *  o "SuperGhosting" use the Superghosting patch by Christopher Williams, which allow elements to be dragged from an
	 *    scrollable list
	 *  o "False" or "None" means no Ghosting options
	 *
	 */
	public function setGhosting ($value)
	{
		if (strcasecmp($value,'true')==0 || $value===true)
			$value=TDraggableGhostingOptions::Ghosting;
		elseif (strcasecmp($value,'false')==0 || $value===false)
			$value=TDraggableGhostingOptions::None;
		$this->setViewState('Ghosting', TPropertyValue::ensureEnum($value, 'Prado\\Web\\UI\\ActiveControls\\TDraggableGhostingOptions'), TDraggableGhostingOptions::None);
	}

	/**
	 * Determine if the element should be constrainted in one direction or not
	 * @return CDraggableConstraint
	 */
	public function getConstraint()
	{
		return $this->getViewState('Constraint', TDraggableConstraint::None);
	}

	/**
	 * Set wether the element should be constrainted in one direction
	 * @param CDraggableConstraint
	 */
	public function setConstraint($value)
	{
		$this->setViewState('Constraint', TPropertyValue::ensureEnum($value, 'Prado\\Web\\UI\\ActiveControls\\DraggableConstraint'), TDraggableConstraint::None);
	}

	/**
	 * Registers clientscripts
	 *
	 * This method overrides the parent implementation and is invoked before render.
	 * @param mixed event parameter
	 */
	public function onPreRender($param)
	{
		parent::onPreRender($param);
	}

	/**
	 * Ensure that the ID attribute is rendered and registers the javascript code
	 * for initializing the active control.
	 */
	protected function addAttributesToRender($writer)
	{
		parent::addAttributesToRender($writer);

		$cs=$this->getPage()->getClientScript();
		if ($this->getGhosting()==TDraggableGhostingOptions::SuperGhosting)
			$cs->registerPradoScript('dragdropextra');
		else
			$cs->registerPradoScript('dragdrop');
		$writer->addAttribute('id',$this->getClientID());
		$options=TJavaScript::encode($this->getPostBackOptions());
		$class=$this->getClientClassName();
		$code="new {$class}('{$this->getClientId()}', {$options}) ";
		$cs->registerEndScript(sprintf('%08X', crc32($code)), $code);
	}

	/**
	 * Gets the name of the javascript class responsible for performing postback for this control.
	 * This method overrides the parent implementation.
	 * @return string the javascript class name
	 */
	protected function getClientClassName ()
	{
		return 'Draggable';
	}

	/**
	 * Gets the post back options for this textbox.
	 * @return array
	 */
	protected function getPostBackOptions()
	{
		$options['ID'] = $this->getClientID();

		if (($handle=$this->getHandle())!== null) $options['handle']=$handle;
		if (($revert=$this->getRevert())===TDraggableRevertOptions::None)
			$options['revert']=false;
		elseif ($revert==TDraggableRevertOptions::Revert)
			$options['revert']=true;
		else
			$options['revert']=strtolower($revert);
		if (($constraint=$this->getConstraint())!==TDraggableConstraint::None) $options['constraint']=strtolower($constraint);
		switch ($this->getGhosting())
		{
			case TDraggableGhostingOptions::SuperGhosting:
				$options['superghosting']=true;
				break;
			case TDraggableGhostingOptions::Ghosting:
				$options['ghosting']=true;
				break;
		}

		return $options;
	}

}
