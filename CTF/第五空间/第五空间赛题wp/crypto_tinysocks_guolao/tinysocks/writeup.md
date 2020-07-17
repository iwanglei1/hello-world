# Tinysocks

## 解题步骤

题目思路来源于最近shadowsocks最近爆出来的安全问题，即没有采用AEAD从而使得攻击者在AES设定下有机会解密受害者请求的部分内容。

tinysocks使用AES-256-CFB作为Alice与代理服务器通讯时的加密算法，利用两个方面实现对流量的解密：

1. Alice访问的网站是HTTP，而HTTP响应的前几个字符固定为`HTTP/1.1`
2. 加密算法为AES-256-CFB，加密流程和解密流程是等价的。

由此我们可以利用HTTP响应固定的前缀，对流量文件中的密文进行修改，使得解密后的密文成为合法的代理请求。且修改后的代理请求指向攻击者受控的服务器，这样代理服务器就会将解密后的明文发送给攻击者受控的服务器。

具体流程如下：

`[modified_ciphertext_traffic]->proxy->controled_server->[plaintext_traffic]`

