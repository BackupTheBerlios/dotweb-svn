<?php

/**
 * @package DotWeb
 */


/**
 * Print a formated standard error message and call exit()
 */

function fatalError($module, $method, $errstring)
{
    print "dotweb ($module/$method): $errstring";
    exit();
}

?>
