#encoding:utf-8
import socket,threading,time

HOST,PORT="0.0.0.0",58
data={}      #存放身份和ip
socks={}     #存放每个连接的sock和ip
rdata=""     #服务器接收的数据

def selectsock(user):
    sock=""
    for s in socks.keys():
        if data[user]==socks[s]:
            sock=s
            break
    return sock

def fileready(sock,addr,userid,user):
    while True:
        rdata=sock.recv(1024)
        if rdata=='client' or not rdata:
            break
        else:
            s=selectsock(user)
            s.send(rdata)
	
def cvmsg(sock,addr,userid,user):
    try:
        fileready(sock,addr,userid,user)
        s=selectsock(user)
        while True:
            rdata=sock.recv(10240)
            if rdata:
                s.send(rdata)
    except socket.error:
        if userid in data.keys():
            for s in socks.keys():
                if socks[s]==data[userid]:
                    del socks[s]
            del data[userid]

def clrs():
    global socks,data
    stack={}
    for s in socks.keys():
        for i in data.keys():
            if socks[s]==data[i]:
                stack[s]=socks[s]
    socks=stack
	
def tcplink(sock,addr):
    print 'Accept new connection form %s:%s' % addr
    userid=sock.recv(1024)     #此userid存放连接的用户身份和聊天对象身份
    user=userid.split(':')[1]  #user存放聊天对象身份
    userid=userid.split(':')[0]  #存放连接的用户身份
    data[userid]="%s:%s" % addr
    clrs()
    print data
    print socks
    sock.send('connecting...')
    cvmsg(sock,addr,userid,user)
    
if __name__=="__main__":
    s=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
    s.bind((HOST,PORT))
    s.listen(10)
    print "Waiting for connection..."
    while True:
        sock,addr=s.accept()
        threading.Thread(target=tcplink,args=(sock,addr)).start()
        socks[sock]="%s:%s" % addr
