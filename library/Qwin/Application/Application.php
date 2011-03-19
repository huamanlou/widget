<?php
/**
 * Application
 *
 * Copyright (c) 2008-2010 Twin Huang. All rights reserved.
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
 * @package     Qwin
 * @subpackage  Application
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-09-16 16:18:45
 */

class Qwin_Application_Application
{
    protected $_path;

    /**
     * 获取默认的应用目录路径
     *
     * @return string 资源库中的应用目录路径
     * @todo 分清资源库和网站的应用目录
     * @todo !!!不应包含在该类中
     */
    public function getDefultPath()
    {
        return realpath(QWIN . '/application');
    }

    /**
     * @todo !!!不应包含在该类中
     */
    public function getRootAppPath()
    {
        return realpath(QWIN_ROOT_PATH . '/application');
    }

    /**
     * 根据应用的路径,找出所有命名空间,忽略以.和_开头的命名空间
     * .和_是svn或其他程序的文件
     *
     * @param string $path 应用的路径
     * @return array 命名空间数组
     */
    public function getPackage($path)
    {
        $package = array();
        $path .= '/';
        foreach(scandir($path) as $file)
        {
            $firstLetter = substr($file, 0, 1);
            if($firstLetter == '.' || $firstLetter == '_')
            {
                continue;
            }
            if(is_dir($path . $file))
            {
                $package[] = $file;
            }
        }
        return $package;
    }

    /**
     * 根据应用的路径和提供的命名空间数组,找出所有的模块,忽略以.和_开头的命名空间
     *
     * @param string $path 应用的路径
     * @param array $packageList 命名空间数组,一般由$this->_getPackage()获取
     * @return array 模块数组
     */
    public function getModule($path, $packageList)
    {
        $module = array();
        $path .= '/';
        foreach($packageList as $package)
        {
            foreach(scandir($path . $package) as $file)
            {
                $firstLetter = substr($file, 0, 1);
                if($firstLetter == '.' || $firstLetter == '_')
                {
                    continue;
                }
                if(is_dir($path . $package . '/' . $file))
                {
                    $module[$package][] = $file;
                }
            }
        }
        return $module;
    }

    /**
     * 根据应用的路径和提供的模块数组,找出所有的控制器
     *
     * @param string $path 应用的路径
     * @param array $moduleList 模块数组,一般由$this->_getModule()获取
     * @return array 控制器数组
     */
    public function getController($path, $moduleList)
    {
        $controller = array();
        foreach($moduleList as $package => $moduleList2)
        {
            foreach($moduleList2 as $module)
            {
                // 伪模块或不完整模块不包含Controller目录
                if(!is_dir($path . '/' . $package . '/' . $module . '/Controller'))
                {
                    continue;
                }
                foreach(scandir($path . '/' . $package . '/' . $module . '/Controller') as $file)
                {
                    $name = basename($file, '.php');
                    if($name != $file)
                    {
                        $controller[$package][$module][] = $name;
                    }
                }
            }
        }
        return $controller;
    }

    /**
     * 根据应用的路径和提供的控制器数组,找出所有的行为
     *
     * @param string $path 应用的路径
     * @param array $moduleList 控制器数组,一般由$this->_getController()获取
     * @return array 行为数组
     */
    public function getAction($path, $controllerList)
    {
        $action = array();
        foreach($controllerList as $package => $moduleList)
        {
            foreach($moduleList as $module => $controllerList)
            {
                foreach($controllerList as  $controller)
                {
                    $class = $package . '_' . $module . '_Controller_' . $controller;
                    /**
                     * 取出action类型的方法
                     */
                    if(class_exists($class))
                    {
                        $methodList = get_class_methods($class);
                        $varList = get_class_vars($class);
                        // 删除禁用的行为
                        if (isset($varList['_unableAction'])) {
                            foreach ($varList['_unableAction'] as $unableAction) {
                                $key = array_search('action' . ucfirst($unableAction), $methodList);
                                if (false !== $key) {
                                     unset($methodList[$key]);
                                }
                            }
                        }
                        foreach($methodList as $method)
                        {
                            if('action' == substr($method, 0, 6))
                            {
                                $actionName = substr($method, 6);
//                                $method = new ReflectionMethod('Application_Article_Controller_Article', 'actionIndex');
//                                preg_match("/\/\*\*[\s]+\*\s(.+?)[\s]+\*/i", $doc, $matches);
//                                p($matches);
                                $action[$package][$module][$controller][] = $actionName;
                            }
                        }
                    }
                }
            }
        }
        return $action;
    }
}
