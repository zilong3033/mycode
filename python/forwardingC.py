#encoding:utf-8
import socket,sys,threading,time

class PipeThread(threading.Thread):
    def __init__(self,source,target,local,localport):
        threading.Thread.__init__(self)
        self.source=source
        self.target=target
        self.localport=localport
        self.local=local
    def run(self):
        while True:
            try:
                data=self.source.recv(1024)
                if not data:
                    break
                self.target.send(data)
            except socket.error:
                remote=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
                remote.connect(("127.0.0.1",self.localport))
                PipeThread(self.local,remote,self.local,self.localport).start()
                PipeThread(remote,self.local,self.local,self.localport).start()
                break

class Forwarding(threading.Thread):
    def __init__(self,localport,remoteip,remoteport):
        threading.Thread.__init__(self)
        self.localport=int(localport)
        self.remoteip=remoteip
        self.remoteport=int(remoteport)
    
    def run(self):
        local=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
        remote=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
        local.connect((self.remoteip,self.remoteport))
        remote.connect(("127.0.0.1",self.localport))
        PipeThread(local,remote,local,self.localport).start()
        PipeThread(remote,local,local,self.localport).start()
        
if __name__=="__main__":
    if len(sys.argv)==4:
        Forwarding(sys.argv[1],sys.argv[2],sys.argv[3]).start()
    else:
        print "please input 3 argv!"          
        
        
        

