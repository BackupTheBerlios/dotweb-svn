<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

/**
 * Base class for all HTML controls
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class HTMLControl
{
    /**
     * @access private
     * @var    string
     */
    var $_id = '';
    /**
     * @access private
     * @var    string
     */
    var $_class = '';
    /**
     * @access private
     * @var    string
     */
    var $_title = '';
    /**
     * @access private
     * @var    string
     */
    var $_name = '';
    /**
     * @access private
     * @var    string
     */
    var $_style = '';
    /**
     * @access private
     * @var    boolean
     */
    var $_visible = true;
    /**
     * @access private
     * @var    string
     */
    var $_content = '';

    /**
     * Constructor of HTMLControl which requires the id of the control as parameter
     *
     * @access public
     * @param  string
     */
    function HTMLControl($id)
    {
        $this->setID($id);
    }

    /**
     * Read in an array of attributes and apply them to the object
     *
     * @access public
     * @param  array
     */
    function processAttribs($attribs)
    {
        if ( isset($attribs['id']) )
        {
            $this->setID($attribs['id']);
            if (!$this->_name)
                $this->setName($attribs['id']);
        }
        if ( isset($attribs['class']) )
        {
            $this->setClass($attribs['class']);
        }
        if ( isset($attribs['title']) )
        {
            $this->setTitle($attribs['title']);
        }
        if ( isset($attribs['name']) )
        {
            $this->setName($attribs['name']);
        }
        if ( isset($attribs['style']) )
        {
            $this->setStyle($attribs['style']);
        }
        if ( isset($attribs['visible']) )
        {
            if (strtolower(trim($attribs['visible'])) == 'true')
            {
                $this->_visible = true;
            }
            else
            {
                $this->_visible = false;
            }
        }
    }

    /**
     * Set the id of the control
     *
     * @access public
     * @param  string
     */
    function setID($id)
    {
        $this->_id = $id;
    }

    /**
     * Set the CSS class of the control
     *
     * @access public
     * @param  string
     */
    function setClass($class)
    {
        $this->_class = $class;
    }

    /**
     * Set the title of the control
     *
     * @access public
     * @param  string
     */
    function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * Set the name of the control
     *
     * @access public
     * @param  string
     */
    function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Set the CSS style of the control
     *
     * @access public
     * @param  string
     */
    function setStyle($style)
    {
        $this->_style = $style;
    }

    /**
     * Hide the control (a hidden control returns NO HTML code)
     *
     * @access public
     */
    function hide()
    {
        $this->_visible = false;
    }

    /**
     * Show the control
     *
     * @access public
     */
    function show()
    {
        $this->_visible = true;
    }

    /**
     * Set the content of the control (<tag> $content </tag>)
     *
     * @access public
     * @param  string
     */
    function setContent($content)
    {
        $this->_content = $content;
    }

    /**
     * Return the content of the control
     *
     * @access public
     * @return string
     */
    function getContent()
    {
        return $this->_content;
    }

    /**
     * Virtual method implemented by all HTML controls which returns the HTML code of the specific control
     *
     * @access public
     */
    function getCode()
    {
        return;
    }

    /**
     * Return the html code for the attributes of HTMLControl
     *
     * @access public
     * @return string
     */
    function getBaseCode()
    {
        $code = '';

        if ($this->_visible)
        {
            if ($this->_id)
                $code = $code.' id="'.$this->_id.'"';
            if ($this->_class)
                $code = $code.' class="'.$this->_class.'"';
            if ($this->_title)
                $code = $code.' title="'.$this->_title.'"';
            if ($this->_name)
                $code = $code.' name="'.$this->_name.'"';
            if ($this->_style)
                $code = $code.' style="'.$this->_style.'"';
        }

        return $code;
    }
}

?>
