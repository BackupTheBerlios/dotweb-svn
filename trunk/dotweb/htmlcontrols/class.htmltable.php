<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once('dotweb/htmlcontrols/class.htmlcontrol.php');

/**
 * Control for a HTML table
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLTable extends HTMLControl
{
    var $cols = '';

    function HTMLTable($id)
    {
        parent::HTMLControl($id);
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);
    }

    function getCode()
    {
        if ($this->visible == false)
        {
            return '';
        }
    
        $code = '<table'.$this->getBaseCode();

        $code .= '>'.$this->content.'</table>';

        return $code;
    }
}
