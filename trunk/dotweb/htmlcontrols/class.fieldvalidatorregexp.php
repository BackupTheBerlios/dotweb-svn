<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once("dotweb/htmlcontrols/class.fieldvalidator.php");

/**
 * Validator which checks a field by applying a regexp to it
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class FieldValidatorRegexp extends FieldValidator
{
    /**
     * @access private
     * @var    string  Regular expression (POSIX Extended) with which the field shall be validated
     */
    var $_regexp = '';
    /**
     * @access private
     * @var    string  Regular expression (Perl compatible) with which the field shall be validated
     */
    var $_regexpperl = '';

    function FieldValidatorRegexp($id)
    {
        parent::FieldValidator($id);
    }

    /**
     * @access public
     * @param  array Array of tag attributes
     */
    function processAttribs($attribs)
    {
        parent::processAttribs($attribs);

        if ( isset($attribs['regexp']) )
        {
            $this->setRegexp($attribs['regexp']);
        }

        if ( isset($attribs['regexpperl']) )
        {
            $this->setRegexpPerl($attribs['regexpperl']);
        }
    }

    /**
     * Set the regexp (POSIX Extended) of this validator
     *
     * @access public
     * @param  string Regular Expression
     */
    function setRegexp($regexp)
    {
        $this->_regexp = $regexp;
        $this->_regexpperl = '';
    }

    /**
     * Get the regexp (POSIX Extended) of this validator
     *
     * @access public
     * @return string Regular Expression
     */
    function getRegexp()
    {
        return $this->_regexp;
    }

    /**
     * Set the regexp (Perl compatible) of this validator
     *
     * @access public
     * @param  string Regular Expression
     */
    function setRegexpPerl($regexp)
    {
        $this->_regexpperl = $regexp;
        $this->_regexp = '';
    }

    /**
     * Get the regexp (Perl compatible) of this validator
     *
     * @access public
     * @return string Regular Expression
     */
    function getRegexpPerl()
    {
        return $this->_regexpperl;
    }

    /**
     * Validate the field
     *
     * @access public
     * @return bool
     */
    function isValid()
    {
        if ($this->_isvalidated)
            return $this->_isvalid;

        $this->_isvalidated = true;

        if (!$this->_field->wasSubmitted())
        {
            $this->hide();
            return;
        }

        $value = $this->_field->getSubmitValue();

        // do not validate empty strings
        if (strlen($value) == 0)
        {
            $this->_isvalid = true;
            return $this->_isvalid;
        }
        
        $this->_isvalid = false;

        $regexp = $this->getRegexp(); 

        if ($regexp)
        {
            if (ereg($regexp, $value))
                $this->_isvalid = true;
        }
        else
        {
            $regexp = $this->getRegexpPerl();
            if (ereg($regexp, $value))
                $this->_isvalid = true;
        }
    
        return $this->_isvalid;
    }
}
