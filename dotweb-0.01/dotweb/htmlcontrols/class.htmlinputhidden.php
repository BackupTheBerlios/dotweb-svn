<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once('dotweb/htmlcontrols/class.htmlcontrol.php');

/**
 * HTML control for hidden input fields
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLInputHidden extends HTMLControl
{
    /**
     * @access private
     * @var    string
     */
    var $_value = '';

    function HTMLInputHidden($id)
    {
        parent::HTMLControl($id);
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        if ($attribs['value'])
        {
            $this->setValue($attribs['value']);
        }
    }

    /**
     * Set the value of the hidden field
     *
     * @access public
     * @param  string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Alias method for <i>setValue()</i>
     *
     * @access public
     * @param  string
     */
    function setText($text)
    {
        $this->setValue($text);
    }

    /**
     * Returns the HTML code of the control
     *
     * @access public
     * @return string HTML code
     */
    function getCode()
    {
        if ($this->_visible == false)
        {
            return '';
        }
    
        $code = '<input'.$this->getBaseCode();
        $code .= ' type="hidden"';

        $code .= ' value="'.$this->_value.'"/>';

        return $code;
    }
}
