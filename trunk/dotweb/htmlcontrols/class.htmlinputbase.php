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

    function setAutoFillIn($autofillin)
    {
        $this->_autofillin = $autofillin;
    }
}

?>
