<?php
/**
 * Radiobutton input control
 *
 */

require_once('class.htmlinputcheckbox.php');

class HTMLInputRadioButton extends HTMLInputCheckBox
{
    function HTMLInputRadioButton($id)
    {
        parent::HTMLInputCheckBox($id);
    }

    /**
     * @access public
     * @param  array Array of tag attributes
     */
    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        // autofillin
        if ($this->autoFillIn() && $this->wasSubmitted())
        {
            if ($this->getSubmitValue() && $this->getSubmitValue() == $this->getValue())
            {
                $this->setChecked(true);
            }
            else
            {
                $this->setChecked(false);
            }
        }
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

        $code = '<input type="radio"'.$this->getBaseCode();
        if ($this->_value)
            $code .= ' value="'.$this->_value.'"';
        if ($this->_checked)
            $code .= ' checked="checked"';
        $code .= '>';
        if ($this->_bold)
            $code .= ' <b>'.$this->_text.'</b>';
        else
            $code .= ' '.$this->_text;

        return $code;
    }
}

?>
