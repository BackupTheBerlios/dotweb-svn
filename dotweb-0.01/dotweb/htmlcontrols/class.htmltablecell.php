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

    /**
     * @access private
     * @var    boolean
     */
    var $_isheader = false;

    function HTMLTableCell($id, $coldata)
    {
        parent::HTMLControl($id);

        $this->setContent($coldata);
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        if ($attribs['colspan'])
        {
            $this->setColSpan($attribs['colspan']);
        }

        if ($attribs['rowspan'])
        {
            $this->setRowSpan($attribs['rowspan']);
        }
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
            $this->_colspan = $span;
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
            $this->_rowspan = $span;
    }

    /**
     * Set if the cell shall be a header cell (<th>) or just a normal cell (<td>)
     *
     * @access public
     * @param  boolean
     */
    function setIsHeader($isheader)
    {
        $this->_isheader = $isheader;
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
    
        if ($this->_isheader)
        {
            $code = '<th';
        }
        else
        {
            $code = '<td';
        }
        
        $code .= $this->getBaseCode();
        if ($this->_colspan > 1)
            $code .= ' colspan="'.$this->_colspan.'"';
        if ($this->_rowspan > 1)
            $code .= ' rowspan="'.$this->_rowspan.'"';

        $code .= '>'.$this->_content;

        if ($this->_isheader)
        {
            $code .= '</th>';
        }
        else
        {
            $code .= '</td>';
        }

        return $code;
    }
}
