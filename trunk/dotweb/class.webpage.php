<?php

/**
 * @package DotWeb
 */

require_once('dotweb/class.template.php');

/**
 * Basic webpage class which is responsible for the event handling and control flow of a webpage. It can also do all the template stuff for you so you don't need to create an own template object.
 *
 * You need to have a function on_page_load() defined in your script when using this class because this is the default event handler which gets exectued if there is no event triggered.
 *
 * @package DotWeb
 */

class WebPage
{
    /**
     * @access private
     * @var    array
     */
    var $_events_post;
    /**
     * @access private
     * @var    array
     */
    var $_events_get;
    /**
     * @access private
     * @var    resource
     */
    var $_tpl;

    function WebPage()
    {
        $this->_events_post = array();
        $this->_events_get  = array();
    }

    /**
     * Set the template directory and the template file to use and return an array with the templates html controls.
     *
     * @access public
     * @param  string Name of the template directory
     */
    function setTemplate($tpldir, $tplfile)
    {
        $this->_tpl = new Template($tpldir, $tplfile);
        return $this->_tpl->getControls();
    }

    /**
     * Set page title
     *
     * @access public
     * @param  string Title of the webpage
     */
    function setTitle($title)
    {
        $this->_tpl->setTitle($title);
    }

    /**
     * Check if any data was submitted.
     *
     * @access public
     * @return boolean
     */
    function wasSubmitted()
    {
        if (count($_REQUEST))
        {
            return true;
        }

        return false;
    }

    /**
     * Print the output of the template
     *
     * @access public
     * @param  array Array with the html controls of the template
     */
    function printTemplate($controls)
    {
        $this->_tpl->printOutput($controls);
    }

    /**
     * Register an event handler
     *
     * @access public
     * @param  string HTTP method which is either POST or GET
     * @param  string Name of the function handler that shall be called for this event
     * @param  string Name of the $_POST or $_GET variable that is to be checked for this event
     * @param  string Value that this variable must have for the event to be triggered
     */
    function registerEventHandler($method, $funcname, $varname, $value)
    {
        if ($method != "POST" && $method != "GET")
        {
            print "<br/>registerEventHandler: Method has to be POST or GET";
            exit();
        }

        if (!function_exists($funcname))
        {
            print "<br/>registerEventHandler: There is no function with name <b>$funcname</b>";
            exit();
        }

        if ($method == "POST")
        {
            $i = count($this->_events_post);
            $this->_events_post[$i][$varname][0] = $value;
            $this->_events_post[$i][$varname][1] = $funcname;
        }

        if ($method == "GET")
        {
            $i = count($this->_events_get);
            $this->_events_get[$i]["$varname"][0] = $value;
            $this->_events_get[$i]["$varname"][1] = $funcname;
        }
    }

    /**
     * Check if a post event is triggered
     *
     * @access private
     */
    function callEventHandlersPost()
    {
        foreach ($this->_events_post as $entry)
        {
            $entry = each($entry);
            $varname = $entry["key"];
            $value = $entry["value"][0];
            $funcname = $entry["value"][1];

            if (isset($_POST["$varname"]))
            {
                if ($_POST["$varname"] == $value)
                {
                    eval("$funcname();");
                    exit();
                }
            }
        }
    }

    /**
     * Check if a get event is triggered
     *
     * @access private
     */
    function callEventHandlersGet()
    {
        foreach ($this->_events_get as $entry)
        {
            $entry = each($entry);
            $varname = $entry["key"];
            $value = $entry["value"][0];
            $funcname = $entry["value"][1];

            if (isset($_GET["$varname"]))
            {
                if ($_GET["$varname"] == $value)
                {
                    eval("$funcname();");
                    exit();
                }
            }
        }
    }

    /**
     * Execute the webpage this means check if an event is triggered and execute it or execute the default function which is called on_page_load()
     *
     * @access private
     */
    function executePage()
    {
        if (!function_exists("on_page_load"))
        {
            print "You must declare a function &quot;on_page_load&quot;";
            exit();
        }

        if (($_SERVER['REQUEST_METHOD'] == "POST"))
        {
            $this->callEventHandlersPost();
            if (function_exists('on_post_send'))
            {
                on_post_send();
            }
            else
            {
                on_page_load();
            }
            exit();
        }
        else if (is_array($_GET) && count($_GET) > 0)
        {
            $this->callEventHandlersGet();
            if (function_exists('on_get_send'))
            {
                on_get_send();
            }
            else
            {
                on_page_load();
            }
            exit();
        }
        else
        {
            on_page_load();
            exit();
        }
    }

    /**
     * Check if all submitted fields are valid
     *
     * @access public
     * @return boolean
     */
    function isFormValid()
    {
        return $this->_tpl->isFormValid();
    }
}

?>
