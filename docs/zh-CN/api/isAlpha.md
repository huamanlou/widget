[isAlpha()](http://twinh.github.com/widget/api/isAlpha)
=======================================================

检查数据是否只由字母(a-z)组成

### 
```php
bool isAlpha( $input )
```

##### 参数
* **$input** `mixed` 待验证的数据

##### 范例
检查数据是否只由字母组成
```php
<?php

$input = 'abc123';
if ($widget->isAlpha($input)) {
    echo 'success';
} else {
    echo 'failure';
}
```
##### 输出
```php
'failure'
```