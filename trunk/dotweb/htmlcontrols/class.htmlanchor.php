<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once('dotweb/htmlcontrols/class.htmlcontrol.php');

/**
 * HTML control for anchor tags (<a>)
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLAnchor extends HTMLControl
{
    /**
     * @access private
     * @var    string
     */
    var $href = '';

    function HTMLAnchor($id)
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
    
        if ($attribs['href'])
        {
            $this->setHref($attribs['href']);
        }
    }

    /**
     * Set the href or target URL of the anchor
     *
     * @access public
     * @var    string
     */
    function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * Set the text of the link (alias for <i>setContent()</i>)
     *
     * @access public
     * @param  string
     */
    function setText($text)
    {
        $this->setContent($text);
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
            return "";
        }
    
        $code = '<a'.$this->getBaseCode();
        if ($this->href)
            $code .= ' href="'.$this->href.'"';

        $code .= '>'.$this->content.'</a>';

        return $code;
    }
}
