<?php

/**
 * @package    DotWeb
 * @subpackage HTMLControls
 */

require_once("dotweb/htmlcontrols/class.fieldvalidatorregexp.php");

/**
 * This validator checks if an email address is correct
 *
 * @package    DotWeb
 * @subpackage HTMLControls
 */

class FieldValidatorEmail extends FieldValidatorRegexp
{
    function FieldValidatorEmail($id)
    {
        parent::FieldValidatorRegexp($id);

        $this->setRegexp('^[a-zA-Z0-9_\-]+\@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-]+$');
    }
}
