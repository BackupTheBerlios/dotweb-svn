<?php
require_once('dotweb/class.webpage.php');
  
$web = new WebPage();
$controls = $web->setTemplate('./templates', 'form.html');
$web->setTitle('DotWeb: Form Example');

$web->executePage();

function on_page_load()
{
    global $web, $controls;

    init_page();

    $web->printTemplate($controls);
}

function on_get_send()
{
    global $web, $controls;

    init_page();

    if ($web->isFormValid())
    {
        // hide our input form and show the success message
        // which are both in the same template
        $controls['formpers']->hide();
        $controls['areamsg']->show();

        // show the submitted data in a short summary
        $controls['spanfirstname']->setContent($controls['edtfirstname']->getSubmitValue());
        $controls['spanlastname']->setContent($controls['edtlastname']->getSubmitValue());
        $controls['spanemail']->setContent($controls['edtemail']->getSubmitValue());
        $controls['spancountry']->setContent($controls['selcountry']->getSubmitValue());

        // set the correct back link
        $controls['aback']->setHref($_SERVER['PHP_SELF']);
    }

    $web->printTemplate($controls);
}

function init_page()
{
    global $web, $controls;

    $countries = array('',
                       'Australia',
                       'Canada',
                       'China',
                       'Denmark',
                       'France',
                       'Germany',
                       'Greece',
                       'Italy',
                       'Japan',
                       'Netherlands',
                       'Spain',
                       'United Kingdom',
                       'United States');

    foreach ($countries as $country)
    {
        $controls['selcountry']->addOption($country, '');
    }
}

?>
