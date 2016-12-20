__author__="zilong"
#encoding:utf-8

import time,sys,re
class DealLog:
    def __init__(self,count,paths):
        self.count=count
        self.paths=paths

    def lastline(self,fo):   #set point in lastline
        global pos
        try:
            while True:
                pos=pos-1
                try:
                    fo.seek(pos,2)
                    if fo.read(1)=='\n':
                        break
                except:
                    fo.seek(0,0)
                    return fo.readline().strip()
        except:
            exit(1)
        return fo.readline().strip()

    def deallog(self):  #read and deal log
        global pos
        lines=""
        try:
            fo=open(paths)
        except:
            print "log's path was change!"
            exit(0)
        while True:
            try:
                time.sleep(0.01)   # every 0.01s read log file
            except:
                exit(0)
            strl=lines
            lines=""
            pos=0
            for l in range(self.count*2):
                line=self.lastline(fo)
                lines=lines+line
                if lines==strl:
                    continue
                #use re
                if line:
                    reip=re.search(r"[\d]*\.[\d]*\.[\d]*\.[\d]*",line)
                    retime=re.search(r"[\d][\d]/[\S]*/[\d]*:[\d]*:[\d]*:[\d]*",line)
                    reurl=re.search(r"GET[\s][\S]*[\s][\w]*/[\d]\.[\d]",line)
                    restatus=re.search(r"[\s][\d]*[\s]",line)
                    if reip and retime and reurl and restatus:
                        print reip.group()+"  ",reurl.group(),restatus.group().strip(" ")+"  ",retime.group()
                # not use re
                #li=[]
                #li=line.split("\"")
                #if len(li)>=3:                    
#                    print(li[0].split(" ")[0]+"    "+li[1]+" "+li[2].split(" ")[1]+"     "+li[2].split(" ")[2]+"B  "),
 #                   lt=[]
  #                  lt=li[0].split(" ")[3].replace("[","").split(":")
   #                 print(lt[1]+":"+lt[2]+":"+lt[3])
        fo.close()

if __name__=="__main__":
    if len(sys.argv)==2:         #defualt log's path,you can change it
        if sys.argv[1]=='apache':
            paths='/var/log/apache2/access.log'
        if sys.argv[1]=='nginx':
            paths='/usr/local/nginx/logs/access.log'
    if len(sys.argv)==3:
        if sys.argv[1]=='apache':
            paths=sys.argv[2]
        if sys.argv[1]=='nginx':
            paths=sys.argv[2]
    if len(sys.argv)==1:
        paths='/var/log/apache2/access.log'

    c=DealLog(1,paths)   #read one log,from path of log
    c.deallog()
