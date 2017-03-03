<?php
/*
XSLTranformer -- Class to transform XML files using XSL with the Sablotron libraries.
Justin Grant (2000-07-30)
Thanks to Bill Humphries for the original examples on using the Sablotron module.
*/

class XSLTransformer {
    var $xsl, $xml, $output, $error, $processor, $errorcode;

    /* Constructor  */
    function XSLTransformer() {
        $this->processor = xslt_create();
    }

     /* Destructor */
    function destroy() {
        xslt_free ($this->processor);
    }

    /* output methods */
    function setOutput ($string) {
        $this->output = $string;
    }

    function getOutput() {
        return $this->output;
    }

    /* set methods */
    function setXml ($xml) {
        if ($this->isXmlContent($xml))
        {
             $this->xml = $xml;
            return true;
        }
        elseif ( $doc = new docReader($xml) )
        {
            $this->xml    = $doc->getString();
            return true;
        }
        else
        {
            $this->setError ("Could not open $xml");
            return false;
        }
    }

    function setXsl($uri) {
        if ( $doc = new docReader ($uri) ) {
            $this->xsl    = $doc->getString();
            return true;

        }
        else {
            $this->setError ("Could not open $uri");
            return false;
        }
    }

    function isXmlContent($xml)
    {
        if (strcmp(substr($xml,0,5), "<?xml") == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /* transform method */
    function transform()
    {
        $args = array ( '/_xml' => $this->xml, '/_xsl' => $this->xsl );

        $result = xslt_process ($this->processor, 'arg:/_xml', 'arg:/_xsl', NULL, $args);
        if ($result) {
             $this->setOutput ($result);
        }
        else {
//            $err = "Error: " . xslt_error ($this->processor) . " Errorcode: " . xslt_errno ($this->processor);
            $this->setError (xslt_error($this->processor));
            $this->setErrorCode(xslt_errno($this->processor));
        }
    }

    /* Error Handling */
    function setError ($string) {
        $this->error = $string;
    }

     function getError() {
        return $this->error;
    }

     function setErrorCode($string) {
         $this->errorcode = $string;
     }

    function getErrorCode() {
         return $this->errorcode;
    }
}

/* docReader -- read a file or URL as a string */
class docReader {
    var $string;    // public string representation of file
    var $type;        // private URI type: 'file','url'
    var $bignum        = 500000;

    /* public constructor */
    function docReader ($uri) {  // returns integer
        $this->setUri ($uri);
        $this->setType();
        $fp = fopen ($this->getUri(),"r");

        if ($fp) {
             // get length
            if ( $this->getType() == 'file' ) {
                $length = filesize ($this->getUri());
            }
            else {
                $length = $this->bignum;
             }

            $this->setString (fread ($fp, $length));
            fclose($fp);

            return 1;
        }
        else {
            return 0;
        }
    }

    /* determine if a URI is a filename or URL */
    function isFile ($uri) {     // returns boolean
        if (strstr ($uri,'http://') == $uri) {
            return false;
        }
        else {
            return true;
        }
    }

    /* set and get methods */
    function setUri ($string) {
        $this->uri = $string;
    }

    function getUri() {
        return $this->uri;
    }

    function setString ($string) {
        $this->string = $string;
    }

    function getString() {
        return $this->string;
    }

    function setType() {
        if ( $this->isFile ($this->uri) ) {
            $this->type = 'file';
        }
        else {
            $this->type = 'url';
        }
    }

    function getType() {
        return $this->type;
    }
}

?>