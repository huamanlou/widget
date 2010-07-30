<?php
/**
 * default 的名称
 *
 * default 的简要介绍
 *
 * Copyright (c) 2009 Twin. All rights reserved.
 * 
 * LICENSE:
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    Twin Huang <twinh@yahoo.cn>
 * @copyright Twin Huang
 * @license   http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @version   2009-10-31 01:19:12
 * @since     2009-11-24 18:47:32
 */

// 防止直接访问导致错误
!defined('QWIN_PATH') && exit('Forbidden');
?>
<div class="ui-list ui-box ui-widget ui-widget-content ui-corner-all">
    <div class="ui-box-titlebar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"> <span class="ui-box-title"><a href="<?php echo url(array('admin', $this->__query['controller'])); ?>">系统信息</a></span> <a class="ui-box-title-icon ui-corner-all" name=".ui-list-content" href="javascript:void(0)"><span class="ui-icon  ui-icon-circle-triangle-n">open/close</span></a> </div>
    <div class="ui-list-content ui-box-content ui-widget-content">
        <dl>
            <dt>PHP版本号</dt>
            <dd class="ui-widget-content"><?php echo $info['php_version']?></dd>

            <dt>MySQL版本号</dt>
            <dd class="ui-widget-content"><?php echo $info['mysql_server_info']?></dd>

            <dt>服务端信息</dt>
            <dd class="ui-widget-content"><?php echo $info['server_software']?></dd>

            <dt>主机名 (IP:端口)</dt>
            <dd class="ui-widget-content"><?php echo $info['server_addr_port']?></dd>

            <dt>网站目录</dt>
            <dd class="ui-widget-content"><?php echo $info['server_doc_root']?></dd>

            <dt>服务器时间</dt>
            <dd class="ui-widget-content"><?php echo $info['server_time']?></dd>

            <dt>最大上传文件</dt>
            <dd class="ui-widget-content"><?php echo $info['upload_file']?></dd>

            <dt>查看PhpInfo</dt>
            <dd class="ui-widget-content">
                <a href="<?php echo url(array('Admin', '', 'PhpInfo'))?>">查看</a>
            </dd>
        </dl>
    </div>
</div>
