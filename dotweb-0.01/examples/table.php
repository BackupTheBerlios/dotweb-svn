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
    // data array that could also come from a textfile or a database
    $data = array(
                    array('Firefox', '0.9.2', 'Linux, Mac OS X and Windows', 'http://www.mozilla.org/products/firefox/'),
                    array('Mozilla', '1.7.1', 'Linux, Mac OS X and Windows', 'http://www.mozilla.org/products/mozilla1.x'),
                    array('Konqueror', '3.2.3', 'Linux', 'http://www.konqueror.org/'),
                    array('Safari', '1.2', 'Mac OS X', 'http://www.apple.com/safari/'),
                    array('Opera', '7.5', 'Linux, Mac OS X and Windows', 'http://www.opera.com/')
                    
    );

    // table caption and col headings
    $controls['tblbrowsers']->setCaption('Modern Browsers');
    $controls['tblbrowsers']->addHeaderRow(array('Browser', 'Version', 'Supported Operating Systems', 'Website'));

    // fill the table with the array data
    $i = 1;
    foreach ($data as $cur)
    {
        // convert url at the end of the array to a HTML link
        $url = array_pop($cur);
        $link->setHref($url);
        $link->setText($cur[0]);
        array_push($cur, $link->getCode());

        $controls['tblbrowsers']->addRow($cur);
        $row =& $controls['tblbrowsers']->getLastRow();

        // use two different colors for the rows
        if ($i % 2 == 0)
            $row->setClass('bgcolor1');
        else
            $row->setClass('bgcolor2');

        $i++;
    }

    $web->printTemplate($controls);
}

?>
