<?php

/**
 * @package DotWeb
 */

require_once 'dotweb/htmlcontrols/class.htmlanchor.php';
require_once 'dotweb/htmlcontrols/class.htmldiv.php';
require_once 'dotweb/htmlcontrols/class.htmlparagraph.php';
require_once 'dotweb/htmlcontrols/class.htmlform.php';
require_once 'dotweb/htmlcontrols/class.htmlbutton.php';
require_once 'dotweb/htmlcontrols/class.htmlimage.php';
require_once 'dotweb/htmlcontrols/class.htmlselect.php';
require_once 'dotweb/htmlcontrols/class.htmlinputhidden.php';
require_once 'dotweb/htmlcontrols/class.htmlinputtext.php';
require_once 'dotweb/htmlcontrols/class.htmlinputcheckbox.php';
require_once 'dotweb/htmlcontrols/class.htmlinputradiobutton.php';
require_once 'dotweb/htmlcontrols/class.htmlspan.php';
require_once 'dotweb/htmlcontrols/class.htmltextarea.php';
require_once 'dotweb/htmlcontrols/class.htmltable.php';
require_once 'dotweb/htmlcontrols/class.fieldvalidator.php';

/**
 * Class which parses a template, retrieves and creates the objects of the dotweb components used in this template and generates the final output of the template.
 *
 * @package DotWeb
 */

class TemplateParser
{
    /**
     * @access private
     * @var    string
     */
    var $output = "";
    /**
     * @access private
     * @var    string
     */
    var $tplfile = "";
    /**
     * @access private
     * @var    integer
     */
    var $depth = 0;
    /**
     * @access private
     * @var    array
     */
    var $objects = array();
    /**
     * @access private
     * @var    array
     */
    var $_validators = array();
    /**
     * @access private
     * @var    string
     */
    var $_title = '';
    /**
     * @access private
     * @var    array
     */
    var $namestack = array();
    /**
     * @access private
     * @var    array
     */
    var $idstack = array();
    /**
     * @access private
     * @var    array
     */
    var $curcontent = array();
    /**
     * List of html tags which have no content
     * @access private
     * @var    array
     */
    var $nocontent = array('br', 'img', 'input', 'link');

    function TemplateParser()
    {

    }

    /**
     * Set the template file to parse
     *
     * @access public
     * @param  string Name of the template file
     */
    function setInputFile($tplfile)
    {
        $this->tplfile = $tplfile;
    }

    /**
     * Set page title
     *
     * @access public
     * @param  string Title of the webpage
     */
    function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * Setup the FieldValidators after parsing the template
     *
     * @access private
     */
    function validatorSetup()
    {
        $cnt = count($this->_validators);
        for ($i = 0; $i < $cnt; $i++)
        {
            // pass reference for the field object to the validators
            $fname = $this->_validators[$i]->getFieldName();
            $this->_validators[$i]->setField($this->objects[$fname]);
            // validate each field
            $this->_validators[$i]->isValid();
        }
    }

    /**
     * Parse a template and return an array of html objects
     *
     * @access public
     */
    function parse()
    {
        $this->depth = 0;
        $this->objects = array();
    
        $xml_parser = xml_parser_create();
        xml_set_object($xml_parser, $this);
        xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($xml_parser, "startParseHandler", "endParseHandler");
        xml_set_character_data_handler($xml_parser, "charParseHandler");
        if (!($fp = fopen($this->tplfile, "r")))
        {
            die("could not open XML input");
        }

        while ($data = fread($fp, 4096))
        {
            if (!xml_parse($xml_parser, $data, feof($fp)))
            {
                die(sprintf("XML error: %s at line %d",
                                xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser)));
            }
        }
        
        xml_parser_free($xml_parser);

        $this->validatorSetup();

        return $this->objects;
    }

    /**
     * handle start element
     *
     * @access private
     * @param  resource  xml parser resource
     * @param  string    name of the element
     * @param  array     attributes
     */
    function startParseHandler($xp, $name, $attribs)
    {
        $this->depth++;

        if (count($this->namestack))
        {
            $i = count($this->curcontent) - 1;
            $this->curcontent[$i] .= '<'.$name;
            foreach ($attribs as $key => $value)
            {
                $this->curcontent[$i] .= ' '.$key.'="'.$value.'"';
            }
            $this->curcontent[$i] .= '>';
        }

        if ($name == "dotweb:title")
        {
            $this->objects['title'] = 'title';
        }
        else
        // do we have a dotweb tag?
        if (ereg("^dotweb:", $name))
        {
            // require an id attribute
            if (!isset($attribs['id']) && $name != "dotweb:comment")
                fatalError("TemplateParser", $this->tplfile.': <b>Line '.xml_get_current_line_number($xp).'</b>', $name.' has no id but it is required to have one');
            // check if id is unique
            if (isset($attribs['id']) && array_key_exists($attribs['id'], $this->objects))
                fatalError("TemplateParser", $this->tplfile.': <b>Line '.xml_get_current_line_number($xp).'</b>', 'Ids have to be unique but the id <b>'.$attribs['id'].'</b> is already in use.');

            // check for a specific dotweb tag and create a correspondent object
            if ($name == "dotweb:a")
            {
                $this->objects[$attribs['id']] = new HTMLAnchor($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == "dotweb:img")
            {
                $this->objects[$attribs['id']] = new HTMLImage($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == "dotweb:form")
            {
                $this->objects[$attribs['id']] = new HTMLForm($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == "dotweb:button")
            {
                $this->objects[$attribs['id']] = new HTMLButton($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == "dotweb:select")
            {
                $this->objects[$attribs['id']] = new HTMLSelect($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == 'dotweb:input' && ($attribs['type'] == 'text' || $attribs['type'] == 'password'))
            {
                $this->objects[$attribs['id']] = new HTMLInputText($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == 'dotweb:input' && $attribs['type'] == 'hidden')
            {
                $this->objects[$attribs['id']] = new HTMLInputHidden($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == 'dotweb:input' && $attribs['type'] == 'checkbox')
            {
                $this->objects[$attribs['id']] = new HTMLInputCheckBox($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == 'dotweb:input' && $attribs['type'] == 'radio')
            {
                $this->objects[$attribs['id']] = new HTMLInputRadioButton($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == 'dotweb:textarea')
            {
                $this->objects[$attribs['id']] = new HTMLTextArea($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == "dotweb:p")
            {
                $this->objects[$attribs['id']] = new HTMLParagraph($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == "dotweb:div")
            {
                $this->objects[$attribs['id']] = new HTMLDiv($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == "dotweb:span")
            {
                $this->objects[$attribs['id']] = new HTMLSpan($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            else if ($name == "dotweb:table")
            {
                $this->objects[$attribs['id']] = new HTMLTable($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
            }
            // field validator stuff
            else if ($name == "dotweb:fieldvalidator")
            {
                $this->objects[$attribs['id']] = new FieldValidator($attribs['id']);
                $this->objects[$attribs['id']]->processAttribs($attribs);
                $this->_validators[] = &$this->objects[$attribs['id']];
            }

            if ($name != "dotweb:comment")
            {
                array_push($this->namestack, $name);
                array_push($this->idstack, $attribs['id']);
                array_push($this->curcontent, '');
            }
        } 
    }

    /**
     * handle character data
     *
     * @access private
     * @param  resource  xml parser resource
     * @param  string    character data
     */
    function charParseHandler($xp, $data)
    {
        if (count($this->namestack))
        {
            $i = count($this->curcontent) - 1;
            $this->curcontent[$i] .= $data;
        }
    }

    /**
     * handle end element
     *
     * @access private
     * @param  resource  xml parser resource
     * @param  string    name of the element
     */
    function endParseHandler($xp, $name)
    {
        if (ereg("^dotweb:", $name))
        {
            if (count($this->namestack))
            {
                array_pop($this->namestack);
                $id = array_pop($this->idstack);
                $cont = array_pop($this->curcontent);

                
                if (count($this->curcontent))
                {
                    $i = count($this->curcontent) - 1;
                    $this->curcontent[$i] = $this->curcontent[$i].'</'.$name.'>';
                }

                if (!$this->objects[$id]->getContent())
                    $this->objects[$id]->setContent($cont);
            }
        }
        else if (count($this->namestack))
        {
            $i = count($this->curcontent) - 1;
            $this->curcontent[$i] = $this->curcontent[$i].'</'.$name.'>';
        }
        $this->depth--;
    }

    /**
     * Return the output of the parsed template
     *
     * @access public
     * @param  array  Array of html objects
     * @param  string Use this optional xml code if set instead of the template file
     */
    function getOutput($objects, $xmldata = '')
    {
        $this->output = "";
        $this->objects = "";
        $this->objects = $objects;

        $xml_parser = xml_parser_create();
        xml_set_object($xml_parser, $this);
        xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($xml_parser, "startOutHandler", "endOutHandler");
        xml_set_character_data_handler($xml_parser, "charOutHandler");
        xml_set_default_handler($xml_parser, "defaultOutHandler");

        if ($xmldata)
        {
            if (!xml_parse($xml_parser, $xmldata, true))
            {
                die(sprintf("XML error: %s at line %d",
                            xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser)));
            }
        }
        else
        {
            if (!($fp = fopen($this->tplfile, "r")))
            {
                die("could not open XML input");
            }

            while ($data = fread($fp, 4096))
            {
                if (!xml_parse($xml_parser, $data, feof($fp)))
                {
                    die(sprintf("XML error: %s at line %d",
                                xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser)));
                }
            }
        }
        
        xml_parser_free($xml_parser);
        return $this->output;
    }

    /**
     * default handler
     *
     * @access private
     * @param  resource  xml parser resource
     * @param  string    Character data
     */
    function defaultOutHandler($xp, $data)
    {
        // output every unknown data from the template except for the XML declaration (IE6 doesn't like it in html)
        if (!ereg("\<?xml", $data))
        {
            $this->output .= $data;
        }
    }

    /**
     * handle start tags
     *
     * @access private
     * @param  resource  xml parser resource
     * @param  string    name of the element
     * @param  string    Element attributes
     */
    function startOutHandler($xp, $name, $attribs)
    {
        // put all non dotweb tags in the output stream the same way they look like in the template
        if (!ereg('^dotweb:', $name))
        {
            if (count($this->namestack) == 0 && $name != 'helper')
            {
                $this->output .= '<'.$name;
                foreach ($attribs as $key => $value)
                {
                    $this->output .= ' '.$key.'="'.$value.'"';
                }
                if (in_array($name, $this->nocontent))
                {
                    $this->output .= '/>';
                }
                else
                {
                    $this->output .= '>';
                }
            }
        }
        else
        {
            if ($name == 'dotweb:title')
            {
                $this->output .= '<title>'.$this->_title.'</title>';
            }
            if ( isset($attribs['id']) && count($this->namestack) == 0)
            {
                if ($cont = $this->objects[$attribs['id']]->getContent())
                {
                    $tplparser = new TemplateParser();
                    $cont = $tplparser->getOutput($this->objects, '<helper>'.$cont.'</helper>');
                    $this->objects[$attribs['id']]->setContent($cont);
                }
                $this->output .= $this->objects[$attribs['id']]->getCode();
            }
            array_push($this->namestack, $name);
        }
    }

    /**
     * handle character data
     *
     * @access private
     * @param  resource  xml parser resource
     * @param  string    Character data
     */
    function charOutHandler($xp, $data)
    {
        if (count($this->namestack) == 0)
        {
            $this->output .= $data;
        }
    }

    /**
     * handle end element
     *
     * @access private
     * @param  resource  xml parser resource
     * @param  string    name of the element
     */
    function endOutHandler($xp, $name)
    {
        if (count($this->namestack) == 0 && $name != 'helper')
        {
            if (!in_array($name, $this->nocontent))
                $this->output .= '</'.$name.'>';
        }
        if (ereg('^dotweb:', $name))
        {
            array_pop($this->namestack);
        }
    }

    /**
     * Check if all submitted fields are valid
     *
     * @access public
     * @return boolean
     */
    function isFormValid()
    {
        for ($i = 0; $i < count($this->_validators); $i++)
        {
            if (!$this->_validators[$i]->isValid())
            {
                return false;
            }
        }

        return true;
    }

}
?>
