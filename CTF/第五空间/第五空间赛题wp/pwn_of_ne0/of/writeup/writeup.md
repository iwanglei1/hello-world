## 题目考点
UAF, 编译器优化


## 漏洞成因
这个是个堆题，如果我们只看源代码的话，是看不出漏洞的，而这道题我们只提供源代码。
题目有`allocate, edit, show, delete`几个功能。我们从`urandom`读了一个8字节的随机数当做`cookie`，只有`cookie`正确才能做操作，free的时候我们把`cookie`清零。
然而编译器(`gcc`和`clang`)都会把这个清0操作给优化掉，导致`UAF`。题目一开始就打印了这个是`ubuntu 18`编译的，选手只需要自己编译逆向就可以发现问题，但是要开`O3`优化。或者直接打一下远程也可以发现这个问题。只看源代码的话就没法做出这个题。


## Exploit
