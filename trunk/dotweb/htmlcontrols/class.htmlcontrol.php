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
    var $id = '';
    /**
     * @access private
     * @var    string
     */
    var $class = '';
    /**
     * @access private
     * @var    string
     */
    var $title = '';
    /**
     * @access private
     * @var    string
     */
    var $name = '';
    /**
     * @access private
     * @var    string
     */
    var $style = '';
    /**
     * @access private
     * @var    boolean
     */
    var $visible = true;
    /**
     * @access private
     * @var    string
     */
    var $content = '';

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
        if ($attribs['id'])
        {
            $this->setID($attribs['id']);
        }
        if ($attribs['class'])
        {
            $this->setClass($attribs['class']);
        }
        if ($attribs['title'])
        {
            $this->setTitle($attribs['title']);
        }
        if ($attribs['name'])
        {
            $this->setName($attribs['name']);
        }
        if ($attribs['style'])
        {
            $this->setStyle($attribs['style']);
        }
        if ($attribs['visible'])
        {
            if (strtolower(trim($attribs['visible'])) == 'true')
            {
                $this->visible = true;
            }
            else
            {
                $this->visible = false;
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
        $this->id = $id;
    }

    /**
     * Set the CSS class of the control
     *
     * @access public
     * @param  string
     */
    function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * Set the title of the control
     *
     * @access public
     * @param  string
     */
    function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set the name of the control
     *
     * @access public
     * @param  string
     */
    function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set the CSS style of the control
     *
     * @access public
     * @param  string
     */
    function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * Hide the control (a hidden control returns NO HTML code)
     *
     * @access public
     */
    function hide()
    {
        $this->visible = false;
    }

    /**
     * Show the control
     *
     * @access public
     */
    function show()
    {
        $this->visible = true;
    }

    /**
     * Set the content of the control (<tag> $content </tag>)
     *
     * @access public
     * @param  string
     */
    function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Return the content of the control
     *
     * @access public
     * @return string
     */
    function getContent()
    {
        return $this->content;
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

        if ($this->visible)
        {
            if ($this->id)
                $code = $code.' id="'.$this->id.'"';
            if ($this->class)
                $code = $code.' class="'.$this->class.'"';
            if ($this->title)
                $code = $code.' title="'.$this->title.'"';
            if ($this->name)
                $code = $code.' name="'.$this->name.'"';
            if ($this->style)
                $code = $code.' style="'.$this->style.'"';
        }

        return $code;
    }
}

?>
