<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once("dotweb/htmlcontrols/class.htmlcontrol.php");

/**
 * Manage a <span> tag
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class FieldValidator extends HTMLControl
{
    /**
     * @access private
     * @var    reference Name of the field that shall be validated
     */
    var $_field;
    /**
     * @access private
     * @var    string Name of the field that shall be validated
     */
    var $_fieldname = '';
    /**
     * @access private
     * @var    bool Result of the validation
     */
    var $_isvalid = false;
   /**
     * @access private
     * @var    bool Is the field validated already?
     */
    var $_isvalidated = false;

    function FieldValidator($id)
    {
        parent::HTMLControl($id);

        $this->_style = 'color: red';
    }

    /**
     * @access public
     * @param  array Array of tag attributes
     */
    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        if ( isset($attribs['field']) )
        {
            $this->setFieldName($attribs['field']);
        }
    }

    /**
     * Set a reference on the field that shall be validated
     *
     * @access public
     * @param  reference Reference on the field object
     */
    function setField(&$field)
    {
        $this->_field = $field;
    }

    /**
     * Set the id of the field that shall be validated
     *
     * @access public
     * @param  reference Name of the field
     */
    function setFieldName($fieldname)
    {
        $this->_fieldname = $fieldname;
    }

    /**
     * Get the id of the field that shall be validated
     *
     * @access public
     * @return string Id of the field
     */
    function getFieldName()
    {
        return $this->_fieldname;
    }

    /**
     * Validate the field
     *
     * @access public
     * @return string Field id
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
        $value = trim($value);
    
        if (strlen($value) == 0)
        {
            $this->_isvalid = false;
        }
        else
        {
            $this->_isvalid = true;
        }

        return $this->_isvalid;
    }   

    /**
     * Returns the HTML code of the control
     *
     * @access public
     * @return string HTML code
     */
    function getCode()
    {
        if ($this->_visible == false || $this->_isvalid == true)
        {
            return '';
        }
    
        $code = "<span".$this->getBaseCode();

        $code .= ">".$this->_content.'</span>';

        return $code;
    }
}
