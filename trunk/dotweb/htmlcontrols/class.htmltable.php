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

    function HTMLTable($id)
    {
        parent::HTMLControl($id);
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);
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
     * @return reference
     */
    function &getRow($num)
    {
       if ($num < 0 || $num > count($this->_rows))
       {
           // FIXME: PEAR error handling
           exit();
       }

       return $this->_rows[$num];
    }

    function getCode()
    {
        if ($this->_visible == false)
        {
            return '';
        }
    
        $code = '<table'.$this->getBaseCode();
        $code .= '>';
        
        for ($i = 0; $i < count($this->_rows); $i++)
        {
            $code .= $this->_rows[$i]->getCode();
        }
        
        $this->_content.'</table>';

        return $code;
    }
}
