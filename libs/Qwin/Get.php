<?php
/**
 * Qwin Framework
 *
 * Copyright (c) 2008-2012 Twin Huang. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 */

/**
 * Get
 *
 * @package     Qwin
 * @subpackage  Widget
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @author      Twin Huang <twinh@yahoo.cn>
 * @since       2011-10-02 00:44:51
 * @todo        add init data support
 * @todo        add array param support
 */
class Qwin_Get extends Qwin_Widget
{
    /**
     * get data
     *
     * @var array
     */
    protected $_data;

    public function __construct($options = null)
    {
        $this->_data = $_GET;
    }

    public function call($name, $default = null)
    {
        $q = Qwin::getInstance();
        if (is_string($name)) {
            return $q->variable(isset($this->_data[$name]) ? $this->_data[$name] : $default);
        } elseif (is_int($name)) {
            if (!is_int($default)) {
                return $q->variable(isset($this->source[$name]) ? $this->source[$name] : null);
            } else {
                if (is_string($this->source)) {
                    return $q->variable(substr($this->source, $name, $default - $name + 1));
                } elseif (is_array($this->source)) {
                    return $q->variable(array_slice($this->source, $name, $default - $name + 1));
                }
            }
        }
        return $this->invoker;
    }

    /**
     * Add get data
     *
     * @param string|array $name
     * @param mixed $value
     * @return Qwin_Get
     */
    public function add($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->_data[$key] = $value;
                $this->request->add($name, $value);
            }
        } else {
            $this->_data[$name] = $value;
            $this->request->add($name, $value);
        }
        return $this;
    }

    /**
     * Remove get data
     *
     * @param string $name
     * @return Qwin_Get
     */
    public function remove($name)
    {
        if (isset($this->_data[$name])) {
            unset($this->_data[$name]);
        }
        return $this;
    }
}
