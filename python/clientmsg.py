#encoding:UTF-8
import socket,threading,time

HOST,PORT="123.206.28.70",57
user="liu"
ruser="wang"

def recvmsg(s):
    while True:
        rdata=s.recv(1024)
        if rdata:
            print rdata

def sdmsg(s):
    while True:
        sdata=raw_input()
        sdata="%s:%s" % (ruser,sdata)
        if sdata:
            s.send(sdata)

def userid(s):
    users="%s:%s" % (user,ruser)
    s.send(users)
if __name__=="__main__":
    s=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
    s.connect((HOST,PORT))
    userid(s)
    threading.Thread(target=recvmsg,args=(s,)).start()
    threading.Thread(target=sdmsg,args=(s,)).start()