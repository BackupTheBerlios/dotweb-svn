<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once("dotweb/htmlcontrols/class.fieldvalidator.php");

/**
 * Validator which checks a field by applying a custom function to it
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class FieldValidatorCustom extends FieldValidator
{
    /**
     * @access private
     * @var    reference 
     */
    var $_funcname = '';

    function FieldValidatorCustom($id)
    {
        parent::FieldValidator($id);
    }

    /**
     * @access public
     * @param  array Array of tag attributes
     */
    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        if ( isset($attribs['function']) )
        {
            $this->setCustomFunction($attribs['function']);
        }
    }

    /**
     * Set the user function that shall be called for validation
     *
     * @access public
     * @param  string Name of the function to call for validation
     */
    function setCustomFunction($funcname)
    {
        $this->_funcname = $funcname;
    }

    /**
     * Validate the field
     *
     * @access public
     * @return bool
     */
    function isValid()
    {
        if ($this->_isvalidated)
            return $this->_isvalid;

        $this->_isvalidated = true;

        if (!$this->_field->wasSubmitted())
        {
            $this->hide();
            return;
        }

        $value = $this->_field->getSubmitValue();

        $call = 'return '.$this->_funcname.'(\''.$value.'\');';
        $this->_isvalid = eval($call);

        return $this->_isvalid;
    }
}
