#encoding:utf-8
import socket,sys,threading

class PipeThread(threading.Thread):
    def __init__(self,source,target):
        threading.Thread.__init__(self)
        self.source=source
        self.target=target
    
    def run(self):
        while True:
            try:
                data=self.source.recv(1024)
                if not data:
                    break
                self.target.send(data)
            except:
                break

class Forwarding(threading.Thread):
    def __init__(self,localport,remoteip,remoteport):
        threading.Thread.__init__(self)
        self.localport=int(localport)
        self.remoteip=remoteip
        self.remoteport=int(remoteport)
        self.sock=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
        self.sock.bind(("0.0.0.0",self.localport))
        self.sock.listen(10)
    def run(self):
        print "forwarding data.."
        while True:
            local_sock,addr=self.sock.accept()
            remote=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
            remote.connect((self.remoteip,self.remoteport))
            print self.remoteip+":"+str(self.remoteport)+"->"+"local:"+str(self.localport)
            PipeThread(local_sock,remote).start()
            PipeThread(remote,local_sock).start()
        
if __name__=="__main__":
    if len(sys.argv)==4:
       Forwarding(sys.argv[1],sys.argv[2],sys.argv[3]).start()
    else:
        print "please input 3 argv(localport,remoteip,remoteport):"        
