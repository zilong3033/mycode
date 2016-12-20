#encoding:utf-8
import socket,threading,time

HOST,PORT="0.0.0.0",57
data={}      #存放身份和ip
socks={}     #存放每个连接的sock和ip
rdata={}     #服务器接收的数据

def cvmsg(sock,addr,userid,user):     #接收客户端数据并处理
    try:
        for s in socks:
            if (user in data.keys()) and data[user]==socks[s]:
                confag="%s is loadin" % userid
                s.send(confag)
        while True:
            rdata=sock.recv(1024)
            if rdata:
                rdatas="%s:%s" % (userid,rdata.split(':')[1])
                for s in socks:
                    if data[user]==socks[s]:
                        s.send(rdatas)
    except socket.error:
        for s in socks.keys():
            if (user in data.keys()) and socks[s]==data[user]:
                clfag="%s is loadout" % userid
                s.send(clfag)
            if socks[s]==("%s:%s" % addr):
                del socks[s]
        del data[userid]

def tcplink(sock,addr):
    print 'Accept new connection form %s:%s' % addr
    userid=sock.recv(1024)     #此userid存放连接的用户身份和聊天对象身份
    user=userid.split(':')[1]  #user存放聊天对象身份
    userid=userid.split(':')[0]  #存放连接的用户身份
    data[userid]="%s:%s" % addr
    users=[]
    userstr=""
    for s in data:
        users.append(s)
    userstr=",".join(users)
    sock.send('connecting...(%s)' % userstr)
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
        print socks