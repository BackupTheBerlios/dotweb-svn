<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once('dotweb/htmlcontrols/class.htmlcontrol.php');

/**
 * HTML control for buttons
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLButton extends HTMLControl
{
    /**
     * @access private
     * @var    string
     */
    var $_type = 'button';
    /**
     * @access private
     * @var    string
     */
    var $_value = '';

    function HTMLButton($id)
    {
        parent::HTMLControl($id);
    }

    /**
     * @access public
     * @param  array Array of tag attributes
     */
    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        if ( isset($attribs['type']) )
        {
            $this->setButtonType($attribs['type']);
        }
        if ( isset($attribs['value']) )
        {
            $this->setValue($attribs['value']);
        }
    }

    /**
     * Set the text of the button (alias for <i>setContent()</i>)
     *
     * @access public
     * @param  string
     */
    function setText($text)
    {
        $this->setContent($text);
    }

    /**
     * Set the value of the button
     *
     * @access public
     * @param  string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Set the button type
     *
     * @access public
     * @var    string
     */
    function setButtonType($type)
    {
        //FIXME: PEAR error handling
        if ($type != 'button' && $type != 'submit' && $type != 'reset')
            return false;
    
        $this->_type = $type;
        return true;
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
    
        $code = '<button'.$this->getBaseCode();
        if ($this->_value)
            $code .= ' value="'.$this->_value.'"';
        $code .= ' type="'.$this->_type.'"';

        $code .= '>'.$this->_content.'</button>';

        return $code;
    }
}
