<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once("dotweb/htmlcontrols/class.htmlcontrol.php");
require_once("dotweb/htmlcontrols/class.htmltablecell.php");

/**
 * HTML Control for the <tr> HTML tag
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLTableRow extends HTMLControl
{
    /**
     * @access private
     * @var    array List of the TableCells that belong to this row
     */
    var $_cells = array();

    function HTMLTableRow($id, $coldata)
    {
        parent::HTMLControl($id);

        $num = count($coldata);
        for ($i = 0; $i < $num; $i++)
        {
            $this->_cells[] = new HTMLTableCell($id, $coldata[$i]);
        }
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);
    }

    /**
     * Get the number of cells in the row
     *
     * @access public
     * @return integer Number of cells
     */
    function getCellCount()
    {
        return count($this->_cells);
    }

    /**
     * Get a reference on a cell by its index (first row is 0)
     *
     * @access public
     * @param  integer Index of the row
     * @return reference
     */
    function &getCell($num)
    {
        if ($num < 0 || $num >= count($this->_cells))
        {
            // FIXME: PEAR error handling
            print 'ERROR: There is no row with the index '.$num;
            exit();
        }

        return $this->_cells[$num];
    }

    function getCode()
    {
        if ($this->_visible == false)
        {
            return '';
        }

        $code  = "\n<tr";
        $code .= $this->getBaseCode() . '>';

        for ($i = 0; $i < count($this->_cells); $i++)
        {
            $code .= $this->_cells[$i]->getCode();
        }

        $code .= '</tr>';

        return $code;
    }
}
