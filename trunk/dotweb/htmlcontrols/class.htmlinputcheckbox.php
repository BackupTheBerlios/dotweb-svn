<?php
/**
 * Checkbox input control
 *
 */

require_once('class.htmlinputbase.php');

class HTMLInputCheckBox extends HTMLInputBase
{
    /**
     * @access private
     * @var    bool     Is the checkbox checked?
     */
    var $_checked = false;
    /**
     * @access private
     * @var    string    Text that shall be showed after the checkbox
     */
    var $_text = false;
    /**
     * @access private
     * @var    string    Shall the label be bold or normal text weight?
     */
    var $_bold = false;
    /**
     * @access private
     * @var    string    The value to be submitted when the checkbox is checked.
     */
    var $_value = false;

    function HTMLInputCheckBox($id)
    {
        parent::HTMLInputBase($id);
    }

    /**
     * @access public
     * @param  array Array of tag attributes
     */
    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        if ( isset($attribs['value']) )
        {
            $this->setValue($attribs['value']);
        }

        // autofillin
        if ($this->autoFillIn() && $this->wasSubmitted())
        {
            if ($this->getSubmitValue())
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
     * Set if the checkbox is checked or not.
     *
     * @access public
     * @param  bool
     */
    function setChecked($checked)
    {
        $this->_checked = $checked;
    }

    /**
     * Set the label text of the checkbox.
     *
     * @access public
     * @param  bool
     */
    function setText($text)
    {
        $this->_text = $text;
    }

    /**
     * Set the label to be bold or normal text weight.
     *
     * @access public
     * @param  bool
     */
    function setLabelBold($bold)
    {
        $this->_bold = $bold;
    }

    /**
     * Set the value of the checkbox.
     *
     * @access public
     * @param  string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Get the value of the checkbox.
     *
     * @access public
     * @return string
     */
    function getValue()
    {
        return $this->_value;
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

        $code = '<input type="checkbox"'.$this->getBaseCode();
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
