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

class HTMLSelect extends HTMLInputBase
{
    /**
     * @access private
     * @var    array
     */
    var $_options = array();
    /**
     * @access private
     * @var    integer
     */
    var $_size = 1;
    /**
     * @access private
     * @var    integer
     */
    var $_selected = -1;
    /**
     * @access private
     * @var    boolean
     */
    var $_multiple = 0;

    function HTMLSelect($id)
    {
        parent::HTMLInputBase($id);
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        if ( isset($attribs['size']) )
        {
            $this->setSize($attribs['size']);
        }

        // do the auto fillin
        // FIXME
        /*if ($this->_autofillin && isset($_REQUEST[$this->_name]) )
            $this->setValue($_REQUEST[$this->_name]);*/
    }

    /**
     * Set the size of the selection box. If you set size to 1 you will get a combobox.
     *
     * @access public
     * @param  integer
     */
    function setSize($size)
    {
        $this->_size = $size;
    }

    /**
     * Alias method for <i>setValue()</i>
     *
     * @access public
     * @param  integer
     */
    function setSelected($num)
    {
        $this->_selected = $num;
    }

    /**
     * Allow or deny multiple selection.
     *
     * @access public
     * @param  boolean
     */
    function setMultiple($multiple)
    {
        $this->_multiple = $multiple;
    }

    /**
     * Add another option.
     *
     * @access public
     * @param  string
     * @param  boolean
     */
    function addOption($option, $selected = false)
    {
        $this->_options[] = $option;

        if ($selected)
        {
            $num = count($this->_options) - 1;
            $this->setSelected($num);
        }
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
    
        $code = '<select'.$this->getBaseCode();
        $code .= ' size="'.$this->_size.'"';
        if ($this->_multiple)
            $code .= ' multiple="multiple"';

        $code .= '>';

        $num = count($this->_options);
        for ($i = 0; $i < $num; $i++)
        {
            $code .= "\n<option";
            if ($this->_selected == $i)
                $code .= ' selected="selected"';
            $code .= '>'.$this->_options[$i].'</option>';
        }

        $code .= '</select>';
        return $code;
    }
}
