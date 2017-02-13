#!/usr/bin/env python
#coding=utf8
def createDaemon():
  import os, sys, time
  #产生子进程，而后父进程退出
  try:
    pid = os.fork()
    if pid > 0:sys.exit(0)
  except OSError,error:
    print 'fork'
    sys.exit(1)
  
  #修改子进程工作目录
  os.chdir("/")
  #创建新的会话，子进程成为会话的首进程
  os.setsid()
  #修改工作目录的umask
  os.umask(0)
  
  #创建孙子进程，而后子进程退出
  try:
    pid = os.fork()
    if pid > 0:
      print "Daemon PID %d"%pid
      sys.exit(0)
  except OSError,error:
    print "fork"
    sys.exit(1)
  run()
  
  
def ping():
  import os
  os.system('ping www.baidu.com >/dev/nul')
  
def run():
  while True:
    import time,threading
    fd = open('/home/ping.log', 'a')
    fd.write("start time---------:%s\n"%time.ctime())
    fd.flush()
    t=threading.Thread(target=ping,args=())
    t.start()
    time.sleep(3)
    fd.write("end of time--------:%s\n"%time.ctime())
    fd.flush()
  fd.close()
  
if __name__=='__main__':
  createDaemon()