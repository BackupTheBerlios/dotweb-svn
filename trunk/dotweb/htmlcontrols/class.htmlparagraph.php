<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once("dotweb/htmlcontrols/class.htmlcontrol.php");

/**
 * Manage a <p> tag
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLParagraph extends HTMLControl
{
    function HTMLParagraph($id)
    {
        parent::HTMLControl($id);
    }

    /**
     * @access public
     * @param  array Array of tag attributes
     */
    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);
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
    
        $code = "<p".$this->getBaseCode();

        $code .= ">".$this->_content.'</p>';

        return $code;
    }
}
