<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once("dotweb/htmlcontrols/class.htmlcontrol.php");

/**
 * Manage a <span> tag
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLSpan extends HTMLControl
{
    function HTMLSpan($id)
    {
        parent::HTMLControl($id);
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
    
        $code = "<span".$this->getBaseCode();

        $code .= ">".$this->_content.'</span>';

        return $code;
    }
}
