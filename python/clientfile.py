#encoding:UTF-8
import socket,os,sys

HOST,PORT="127.0.0.1",1234
user="li"
ruser="wang"

def ech(totals,slens):
    persent=int((slens/(totals*1.0))*100)
    sys.stdout.write(str(persent)+'%'+"\r")
    sys.stdout.flush()

def recvfile(s):
    slens=0
    print "please wait a moment...."
    s.send("ready")
    totals=int(s.recv(1024))
    print "the files info"
    print "the file size is:%.2fMB" % (totals/1024.0/1024.0)
    filename=s.recv(1024)
    print "the file name is:%s" % filename
    filedir=raw_input("存放文件路径:")
    filedir="%s\\%s" % (filedir,filename)
    print "saved in:%s" % filedir
    s.send('ok')
    print "recving files...."
    s.send("client")
    f=open(filedir,"wb")
    while True:
        rdata=s.recv(10240)
        slens+=len(rdata)
        ech(totals,slens)
        f.write(rdata)
        if slens>=totals:
            break 
    f.close()
    print "recv file success!"
    s.recv(1024)

def sendfile(s):
    slens=0
    print "please wait a moment..."
    s.recv(1024)
    print "选择要发送的文件:"
    filename=raw_input(">>")
    f = open(filename, 'rb')
    totals=os.path.getsize(filename)
    s.send(str(totals))
    filename=filename.split("\\")[-1]
    s.send(filename)
    print "sending files..."
    s.recv(1024)
    s.send("client")
    while True: 
        data = f.read(10240)
        slens+=len(data)
        ech(totals,slens)
        if not data: 
            break
        s.sendall(data)
    f.close()
    print "send file success!"
    s.recv(1024)

def userid(s):
    users="%s:%s" % (user,ruser)
    s.send(users)

if __name__=="__main__":
    s=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
    while True:
        try:
            s.connect((HOST,PORT))
            break
        except:
            continue
    userid(s)
    userlist=s.recv(1024)
    print userlist
    print "1.发送文件 2.接收文件"
    flag=input()
    if flag==1:
        if ruser in userlist:
            sendfile(s)
        else:
            print "waiting recver connect...."
            s.recv(1024)
            sendfile(s)
    if flag==2:
        if ruser in userlist:                 
            recvfile(s)
        else:
            print "waiting sender connect...."
            s.recv(1024)
            recvfile(s) 