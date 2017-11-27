<?php

/**
 * Smarty Method AppendByRef
 *
 * Smarty::appendByRef() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Undefined
{

    /**
     * This function is executed automatically when a compiled or cached template file is included
     * - Decode saved properties from compiled template and cache files
     * - Check if compiled or cache file is valid
     *
     * @param  \Smarty_Internal_Template $tpl
     * @param  array                     $properties special template properties
     * @param  bool                      $cache      flag if called from cache file
     *
     * @return bool flag if compiled or cache file is valid
     */
    public function decodeProperties(Smarty_Internal_Template $tpl, $properties, $cache = false)
    {
        if ($cache) {
            $tpl->cached->valid = false;
        } else {
            $tpl->mustCompile = true;
        }
        return false;
    }

    /**
     * Call error handler for undefined method
     *
     * @param string $name unknown method-name
     * @param array  $args argument array
     *
     * @return mixed
     * @throws SmartyException
     */
     /* next function copied from smarty_internal_data.php because reported missing in PHP7.1 (EdS)
    public function _isTplObj()
    {
        return $this->_objType === 2;
    }

    public function __call($name, $args)
    {
        throw new SmartyException(get_class($args[ 0 ]) . "->{$name}() undefined method");
    }
    public function __call_old($name, $args)
    {
        if (isset($this->class)) {
            throw new SmartyException("undefined extension class '{$this->class}'");
        } else {
            throw new SmartyException(get_class($args[ 0 ]) . "->{$name}() undefined method");
        }
    }
}