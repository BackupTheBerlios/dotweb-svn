<?php
require_once('dotweb/class.webpage.php');
  
$web = new WebPage();
$controls = $web->setTemplate('./templates', 'table.html');
$web->setTitle('DotWeb: Table Example');

$web->executePage();

function on_page_load()
{
    global $web, $controls;
    $link = new HTMLAnchor('');

    $controls['tblbrowsers']->addHeaderRow(array('Browser', 'Version', 'Supported Operating Systems', 'Website'));

    $link->setHref('http://www.mozilla.org/products/firefox/');
    $link->setText('Firefox');
    $controls['tblbrowsers']->addRow(array('Firefox', '0.9.2', 'Linux, Mac OS X and Windows', $link->getCode()));

    $link->setHref('http://www.mozilla.org/products/mozilla1.x');
    $link->setText('Mozilla');
    $controls['tblbrowsers']->addRow(array('Mozilla', '1.7.1', 'Linux, Mac OS X and Windows', $link->getCode()));

    $link->setHref('http://www.konqueror.org/');
    $link->setText('Konqueror');
    $controls['tblbrowsers']->addRow(array('Konqueror', '3.2.3', 'Linux', $link->getCode()));

    $link->setHref('http://www.apple.com/safari/');
    $link->setText('Safari');
    $controls['tblbrowsers']->addRow(array('Safari', '1.2', 'Mac OS X', $link->getCode()));

    $link->setHref('http://www.opera.com/');
    $link->setText('Opera');
    $controls['tblbrowsers']->addRow(array('Opera', '7.5', 'Linux, Mac OS X and Windows', $link->getCode()));

    $web->printTemplate($controls);
}

?>
