<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once('dotweb/htmlcontrols/class.htmlinputbase.php');

/**
 * HTML control for a text field or a password field
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLInputText extends HTMLInputBase
{
    /**
     * @access private
     * @var    string
     */
    var $_type = 'text';
    /**
     * @access private
     * @var    string
     */
    var $_value = '';
    /**
     * @access private
     * @var    integer
     */
    var $_maxlength = 0;
    /**
     * @access private
     * @var    integer
     */
    var $_size = 0;

    function HTMLInputText($id)
    {
        parent::HTMLInputBase($id);
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        if ( isset($attribs['type']) )
        {
            if (strtolower($attribs['type']) == 'password')
            {
                $this->_type = 'password';
            }
        }
        if ( isset($attribs['value']) )
        {
            $this->setValue($attribs['value']);
        }
        if ( isset($attribs['maxlength']) )
        {
            $this->setMaxlength($attribs['maxlength']);
        }
        if ( isset($attribs['size']) )
        {
            $this->setSize($attribs['size']);
        }
    }

    /**
     * Set if the text field shall be a password field or not
     *
     * @access public
     * @param  boolean
     */
    function setIsPassword($ispass)
    {
        if ($ispass)
        {
            $this->_type = 'password';
        }
        else
        {
            $this->_type = 'text';
        }
    }

    /**
     * Set the value of the text field
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
     * Set the size of the field in characters
     *
     * @access public
     * @param  integer
     */
    function setSize($size)
    {
        $this->_size = $size;
    }

    /**
     * Set the maximum number of characters the user can enter into the text field
     *
     * @access public
     * @param  integer
     */
    function setMaxLength($max)
    {
        $this->_maxlength = $max;
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

        // do the auto fillin
        if ($this->autoFillIn() && $this->wasSubmitted() )
            $this->setValue($this->getSubmitValue());
    
        $code = '<input'.$this->getBaseCode();
        $code .= ' type="'.$this->_type.'"';
        if ($this->_size)
            $code .= ' size="'.$this->_size.'"';
        if ($this->_maxlength)
            $code .= ' maxlength="'.$this->_maxlength.'"';

        $code .= ' value="'.$this->_value.'"/>';

        return $code;
    }
}
