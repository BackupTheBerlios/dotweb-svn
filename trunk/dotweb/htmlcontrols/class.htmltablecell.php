<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once("dotweb/htmlcontrols/class.htmlcontrol.php");

/**
 * HTML Control for the <td> HTML Tag
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLTableCell extends HTMLControl
{
    /**
     * @access private
     * @var    integer
     */
    var $_colspan = 1;
    /**
     * @access private
     * @var    integer
     */
    var $_rowspan = 1;

    function HTMLTableCell($id)
    {
        parent::HTMLControl($id);
    }

    /**
     * Make the cell span over a number of columns
     *
     * @access public
     * @param  integer
     */
    function setColSpan($span)
    {
        if ($span > 1)
            $this-_colspan = $span;
    }

    /**
     * Make the cell span over a number of rows
     *
     * @access public
     * @param  integer
     */
    function setRowSpan($span)
    {
        if ($span > 1)
            $this-_rowspan = $span;
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
    
        $code = '<td'.$this->getBaseCode();
        if ($this->_colspan > 1)
            $code .= ' colspan="'.$this->_colspan.'"';
        if ($this->_rowspan > 1)
            $code .= ' rowspan="'.$this->_rowspan.'"';

        $code .= '>'.$this->content.'</td>';

        return $code;
    }
}
