<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once('dotweb/htmlcontrols/class.htmlcontrol.php');

/**
 * A control for a text input area with multiple lines
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLTextArea extends HTMLControl
{
    /**
     * @access private
     * @var    integer
     */
    var $_cols = 0;
    /**
     * @access private
     * @var    integer
     */
    var $_rows = 0;

    function HTMLTextArea($id)
    {
        parent::HTMLControl($id);
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);
    
        if ($attribs['cols'])
        {
            $this->setCols($attribs['cols']);
        }
        if ($attribs['rows'])
        {
            $this->setRows($attribs['rows']);
        }
    }

    /**
     * Alias method for <i>setContent()</i>
     *
     * @access public
     * @param  string
     */
    function setText($text)
    {
        $this->setContent($text);
    }

    /**
     * Set the width of the text area in characters
     *
     * @access public
     * @param  integer
     */
    function setCols($cols)
    {
        $this->_cols = $cols;
    }

    /**
     * Alias method for <i>setCols()</i>
     *
     * @access public
     * @param  integer
     */
    function setWidth($width)
    {
         $this->setCols($width);
    }

    /**
     * Set the height of the text area in characters
     *
     * @access public
     * @param  integer
     */
    function setRows($rows)
    {
        $this->_rows = $rows;
    }

    /**
     * Alias method for <i>setRows()</i>
     *
     * @access public
     * @param  integer
     */
    function setHeight($height)
    {
        $this->setRows($height);
    }

    /**
     * Returns the HTML code of the control
     *
     * @access public
     * @return string HTML code
     */
    function getCode()
    {
        if ($this->visible == false)
        {
            return '';
        }
    
        $code = '<textarea'.$this->getBaseCode();
        if ($this->_cols)
            $code .= ' cols="'.$this->_cols.'"';
        if ($this->_rows)
            $code .= ' rows="'.$this->_rows.'"';

        $code .= '>'.$this->content.'</textarea>';

        return $code;
    }
}
