<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once("dotweb/htmlcontrols/class.htmlcontrol.php");

/**
 * HTML Control for an Image (<img>)
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLImage extends HTMLControl
{
    /**
     * @access private
     * @var    string
     */
    var $_src = '';
    /**
     * @access private
     * @var    string
     */
    var $_alt = '';
    /**
     * @access private
     * @var    integer
     */
    var $_height = '';
    /**
     * @access private
     * @var    integer
     */
    var $_width = '';

    function HTMLImage($id)
    {
        parent::HTMLControl($id);
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        if ($attribs['src'])
        {
            $this->setSrc($attribs['src']);
        }
        if ($attribs['alt'])
        {
            $this->setAlt($attribs['alt']);
        }
        if ($attribs['height'])
        {
            $this->objects[$attribs['id']]->setHeight($attribs['height']);
        }
        if ($attribs['width'])
        {
            $this->setWidth($attribs['width']);
        }
    }

    /**
     * Set the file path of the image
     *
     * @access public
     * @param  string
     */
    function setSrc($src)
    {
        $this->_src = $src;
    }

    /**
     * Set the alternative text that shall be showed in the case that the image can't be showed
     *
     * @access public
     * @param  string
     */
    function setAlt($alt)
    {
        $this->_alt = $alt;
    }

    /**
     * Set the height of the image
     *
     * @access public
     * @param  integer
     */
    function setHeight($height)
    {
        $this->_height = $height;
    }

    /**
     * Set the width of the image
     *
     * @access public
     * @param  integer
     */
    function setWidth($width)
    {
        $this->_width = $width;
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
    
        $code = '<img'.$this->getBaseCode();
        $code .= ' src="'.$this->_src.'"';
        $code .= ' alt="'.$this->_alt.'"';
        if ($this->_height)
            $code .= ' height="'.$this->_height.'"';
        if ($this->_width)
            $code .= ' width="'.$this->_width.'"';

        $code .= '/>';

        return $code;
    }
}
