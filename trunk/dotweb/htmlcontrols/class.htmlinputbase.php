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
    /**
     * @access private
     * @var    boolean Was this control submitted?
     */
    var $_submitted = false;
    /**
     * @access private
     * @var    string  Submitted value of this control
     */
    var $_submitvalue = '';

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

        if ( isset($attribs['autofillin']) )
        {
            if ($attribs['autofillin'] == 'false')
            {
                $this->setAutoFillIn(false);
            }
        }

        $this->retrieveSubmitValue();
    }

    /**
     * @access public
     * @param  array Array of tag attributes
     */
    function retrieveSubmitValue()
    {
        if ( isset($_REQUEST[$this->_name]) )
        {
            $this->_submitvalue = $_REQUEST[$this->_name];
            $this->_submitted = true;
        }
        else
        {
            $this->_submitted = false;
        }
    }

    /**
     * @access public
     * @return boolean Wheather the control was submitted or not
     */
    function wasSubmitted()
    {
        return $this->_submitted;
    }

    /**
     * Get the value that was submitted for this control
     *
     * @access public
     * @return string The submit value of the control
     */
    function getSubmitValue()
    {
        return $this->_submitvalue;
    }

    /**
     * Enable or disable autofillin for this control
     *
     * @access public
     * @param boolean
     */
    function setAutoFillIn($autofillin)
    {
        $this->_autofillin = $autofillin;
    }

    /**
     * Check if AutoFillIn is active or not
     *
     * @access public
     * @return boolean
     */
    function autoFillIn()
    {
        return $this->_autofillin;
    }
}

?>
