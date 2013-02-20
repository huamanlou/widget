<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

/**
 * Attr
 *
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class Attr
{
    /**
     * Returns the value of specified key in $data
     * 
     * @param mixed $data The data, could be array or instance of \ArrayAccess
     * @param string $key The key of data
     * @return mixed|null Returns null on not found
     */
    public function __invoke($data, $key)
    {
        if ((is_array($data) && array_key_exists($key, $data)) 
            || ($data instanceof \ArrayAccess && $data->offsetExists($key))
        ) {
            return $data[$key];
        } elseif (isset($data->$key)) {
            return $data->$key;
        } elseif (method_exists($data, 'get' . $key)) {
            return $data->{'get' . $key}();
        } else {
            return null;
        }
    }
}
