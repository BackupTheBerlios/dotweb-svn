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
     * @var    array
     */
    var $_values = array();
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
     * Get the total number of options
     *
     * @access public
     * @return integer
     */
    function getOptionCount()
    {
        return count($this->_options);
    }

    /**
     * Select one of the options
     *
     * @access public
     * @param  integer
     */
    function setSelected($num)
    {
        $this->_selected = $num;
    }

    /**
     * Get the number of an entry with the given value.
     *
     * Return -1 if value can't be found.
     *
     * @access public
     * @param  string Value to search for
     */
    function getNumByValue($value)
    {
        $cnt = $this->getOptionCount();

        for ($i = 0; $i < $cnt; $i++)
        {
            if (strlen($this->_values[$i]))
            {
                if ($this->_values[$i] == $value)
                    return $i;
            }
            else
            {
                if ($this->_options[$i] == $value)
                    return $i;
            }
        }

        return -1;
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
    function addOption($option, $value, $selected = false)
    {
        $this->_options[] = $option;
        $this->_values[]  = $value;

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

        // autofillin
        if ($this->autoFillIn() && $this->wasSubmitted())
        {
            if ($value = $this->getSubmitValue())
            {
                $num = $this->getNumByValue($value);
                if ($num > -1)
                {
                    $this->setSelected($num);
                }
            }
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
            if ($this->_values[$i])
                $code .= ' value="'.$this->_values[$i].'"';
            $code .= '>'.$this->_options[$i].'</option>';
        }

        $code .= '</select>';
        return $code;
    }
}
