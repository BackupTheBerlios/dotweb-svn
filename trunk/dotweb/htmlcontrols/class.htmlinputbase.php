<?php
/**
 * Abstract base class for all input conrols
 *
 */

require_once('class.htmlcontrol.php');

class HTMLInputBase extends HTMLControl
{
    /**
     * @access private
     * @var    bool    Autofillin
     */
    var $_autofillin = true;

    function HTMLInputBase($id)
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

    function setAutoFillIn($autofillin)
    {
        $this->_autofillin = $autofillin;
    }
}

?>
