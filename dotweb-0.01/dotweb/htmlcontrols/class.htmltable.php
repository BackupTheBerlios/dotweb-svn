<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once('dotweb/htmlcontrols/class.htmlcontrol.php');
require_once('dotweb/htmlcontrols/class.htmltablerow.php');

/**
 * Control for a HTML table
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLTable extends HTMLControl
{
    /**
     * @access private
     ' @var    integer Number of cols for the whole table
     */
    var $_cols = 0;

    /**
     * @access private
     * @var    array List of all the TableRow objects that belong to this table
     */
    var $_rows = array();

    /**
     * @access private
     * @var    string  Caption of the table
     */
    var $_caption = '';

    function HTMLTable($id)
    {
        parent::HTMLControl($id);
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);
    }

    /**
     * Set the caption of the table
     *
     * @access public
     * @param  string New table caption
     */
    function setCaption($caption)
    {
        $this->_caption = $caption;
    }

    /**
     * Add a new row to the end of the table
     *
     * @access public
     * @param  array List of strings that should go into the TableCells
     */
    function addRow($coldata)
    {
        $this->_rows[] = new HTMLTableRow('', $coldata);
    }

    /**
     * Add a new row of header cells to the current end of the table
     *
     * @access public
     * @param  array List of strings that should go into the TableCells
     */
    function addHeaderRow($coldata)
    {
        $row = new HTMLTableRow('', $coldata);

        $num = $row->getCellCount();
        for ($i = 0; $i < $num; $i++)
        {
            $cell =& $row->getCell($i);
            $cell->setIsHeader(true);
        }
        
        $this->_rows[] = $row;
    }

    /**
     * Get a reference on a row by its index (first row is 0)
     *
     * @access public
     * @param  integer Index of the row
     * @return reference Reference on a TableRow object
     */
    function &getRow($num)
    {
        if ($num < 0 || $num >= count($this->_rows))
        {
            // FIXME: PEAR error handling
            print 'ERROR: There is no row with the index '.$num;
            exit();
        }

        return $this->_rows[$num];
    }

    /**
     * Get a reference on the last row of this table
     *
     * @access public
     * @return reference Reference on a TableRow object
     */
    function &getLastRow()
    {
        $num = count($this->_rows) - 1;
        return $this->getRow($num);
    }

    function getCode()
    {
        if ($this->_visible == false)
        {
            return '';
        }
    
        $code = "\n<table".$this->getBaseCode();
        $code .= '>';

        if ($this->_caption)
            $code .= "\n<caption>".$this->_caption.'</caption>';
        
        for ($i = 0; $i < count($this->_rows); $i++)
        {
            $code .= $this->_rows[$i]->getCode();
        }
        
        $code .= '</table>';

        return $code;
    }
}
