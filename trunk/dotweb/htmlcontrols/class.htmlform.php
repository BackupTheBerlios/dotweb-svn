<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once('dotweb/util.php');
require_once('dotweb/htmlcontrols/class.htmlcontrol.php');

/**
 * HTML control for an HTML form (<form>)
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLForm extends HTMLControl
{
    /**
     * @access private
     * @var    string
     */
    var $_action = '';
    /**
     * @access private
     * @var    string
     */
    var $_method = 'GET';

    function HTMLForm($id)
    {
        parent::HTMLControl($id);
    }

    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);
    
        if ($attribs['action'])
        {
            $this->setAction($attribs['action']);
        }
        if ($attribs['method'])
        {
            $this->setMethod($attribs['method']);
        }
    }

    /**
     * Set the name of the script the browser shall send the from to
     *
     * @access public
     * @param  string
     */
    function setAction($act)
    {
        $this->_action = $act;
    }

    /**
     * Set the method the browser shall use to submit the form. This can be either GET or POST.
     *
     * @access public
     * @param  string
     */
    function setMethod($method)
    {
        if (strtolower($method) != 'post' && strtolower($method) != 'get')
        {
            fatalerror('HTMLForm', '', 'Form method has to be POST or GET');
        }

        $this->_method = $method;
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
    
        $code = "<form".$this->getBaseCode();
        $code .= ' action="'.$this->_action.'"';
        if ($this->_method)
            $code .= ' method="'.$this->_method.'"';

        $code .= '>'.$this->content.'</form>';

        return $code;
    }
}
