#coding=utf-8

import optparse
import socket
import threading
import time

class portScan():
    def __init__(self,tgtHost,strs):
        self.tgtHost=tgtHost
        self.strs=strs
        self.tgtPorts=[]
    
    def dealstr(self):
        self.tgtPorts=self.strs.split(" ")
        print(self.tgtPorts)

    def connScan(self,lock,tgtPort):
        try:
            connSkt=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
            connSkt.connect((self.tgtHost,tgtPort))
            lock.acquire()
            print('[+]%d/tcp open' % tgtPort)
        except:
            lock.acquire()
            print("[-]%d/tcp closed" % tgtPort)
        finally:
            lock.release()
            connSkt.close()

    def portScans(self):
        lock=threading.Semaphore(value=1)
        self.dealstr()
        try:
            tgtIP=socket.gethostbyname(self.tgtHost)
        except:
            print("[-]Cannot resolve '%s':Unknown host" % self.tgtHost)
        try:
            tgtName=socket.gethostbyaddr(tgtIP)
            print("\n[+]Scan Results for:"+tgtName[0])
        except:
            print("\n[+]Scan Results for:"+tgtIP)
        socket.setdefaulttimeout(1)
        for tgtPort in self.tgtPorts:
            print("Scanning port:"+tgtPort)
            t=threading.Thread(target=self.connScan,args=(lock,int(tgtPort)))
            t.start()


'''print("输入扫描地址:")
addr=input()
print("输入要扫描的端口(多个用空格隔开):")
strs=input()
print("正在扫描.....")
s=portScan(addr,strs)
s.portScans()'''