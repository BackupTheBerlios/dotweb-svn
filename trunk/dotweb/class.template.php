<?php

/**
 * @package DotWeb
 */

require_once("util.php");
require_once("dotweb/class.templateparser.php");

/**
 * Template class which is the only class you need to use directly to process a template
 *
 * @package DotWeb
 */

class Template
{
    /**
     * @access private
     * @var    string
     */
    var $_tpldir = '';
    /**
     * @access private
     * @var    string
     */
    var $_tplfile = '';
    /**
     * @access private
     * @var    string
     */
    var $_tplfilec = '';
    /**
     * @access private
     * @var    string
     */
    var $_compiledir = '/tmp/.dotweb';
    /**
     * @access private
     * @var    string
     */
    var $_output = '';
    /**
     * @access private
     * @var    object
     */
    var $_tplparser;

    /**
     * Create a new Template object
     *
     * @access public
     * @param  string Template directory
     * @param  string Filename of the template
     */
    function Template($tpldir, $tplfile)
    {
        $this->_tpldir = $tpldir;
        $this->setTemplate($tplfile);

        $this->_tplparser = new TemplateParser();
    }

    /**
     * Set a new template filename
     *
     * @access public
     * @param  string Filename of the template
     */
    function setTemplate($tplfile)
    {
        $this->_tplfile = $tplfile;
        $this->compileTemplate();
    }

    /**
     * Set page title
     *
     * @access public
     * @param  string Title of the webpage
     */
    function setTitle($title)
    {
        $this->_tplparser->setTitle($title);
    }

    /**
     * Retrieve an array of objects of all controls which are present in the template
     *
     * @access public
     * @return array Array of all kinds of html control objects
     */
    function getControls()
    {
        $this->_tplparser->setInputFile($this->_compiledir.'/'.$this->_tplfilec);
        return $this->_tplparser->parse();
    }

    /**
     * Print the end result of the template with all controls incorporated in it
     *
     * @access public
     * @param  array Array of html control objects from this template
     */
    function printOutput($controls)
    {
        print $this->_tplparser->getOutput($controls);
    }

    /**
     * Return the output of the template.
     *
     * @access public
     * @param  array Array of html control objects from this template
     */
    function getOutput($controls)
    {
        return $this->_tplparser->getOutput($controls);
    }

     /**
     * Compile the template and write the resulting file to /tmp/.dotweb/(md5sum)_(filesize)
     *
     * @access private
     */   
    function compileTemplate()
    {
        $this->compileCheck();
        $this->createOutFile();
    }

    /**
     * Check if the compiledir exists and create it if it does not
     *
     * @access private
     */
    function compileCheck()
    {
        if (file_exists($this->_compiledir))
        {
            if (!is_dir($this->_compiledir))
            {
               fatalError("Template", "compileCheck", "<b>".$this->_compiledir."</b> is a file but needs to be a directory.");
               exit();
            }
        }
        else
        {
            mkdir($this->_compiledir, 0755);
        }
    }

    /**
     * Create the output file /tmp/.dotweb/(md5sum)_(filesize)
     *
     * @access private
     */
    function createOutFile()
    {
        $filename = $this->_tpldir.'/'.$this->_tplfile;
        $hash = md5_file($this->_tpldir.'/'.$this->_tplfile);

        // we use the hash of the real tplfile as the filename
        // of the compiled template
        $this->_tplfilec = $hash.'_'.filesize($filename);
        $filenamec = $this->_compiledir.'/'.$this->_tplfilec;

        if (file_exists($this->_tplfilec))
            return;

        $fp = fopen($filenamec, 'w');
        
        if (!$fp)
        {
            fatalError("Template", "createOutFile", "Can't create the file <b>".$filenamec."</b>");
        }

        $data = $this->compileFile($filename);
        fwrite($fp, $data);

        fclose($fp);
    }

    /**
     * Search for include statements in the template and incorporate the content of those files included into the final template
     *
     * @access private
     * @return string Content of the final template
     */
    function compileFile($filename)
    {
        $fp = fopen($filename, 'r');
        $data = fread($fp, filesize($filename));

        $data = preg_replace_callback("/<dotweb:include\s+file=\"(.+)\"\s*\/>/i", array($this, 'callback'), $data);
        return $data;
    }

    /**
     * Callback function for the regex in compileFile()
     *
     * @access private
     * @return string Content of one included template
     */
    function callback($matches)
    {
        return $this->compileFile($this->_tpldir.'/'.$matches[1]);
    }

    /**
     * Check if all submitted fields are valid
     *
     * @access public
     * @return boolean
     */
    function isFormValid()
    {
        return $this->_tplparser->isFormValid();
    }

}

?>
