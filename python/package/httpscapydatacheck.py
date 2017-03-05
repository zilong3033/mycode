from scapy.all import *
import sys,re,time,threading
from class_datacheck import Datacheck

statuscode=[]
status=""

def check_data(data,log):
    d=Datacheck(data)
    if d.xsscheck():
        print log
    if d.sqlcheck():
        print log

def FilterPacket(packet):
    global statuscode,status,data,log
    if packet[TCP].payload:
        strs=str(packet[Raw])
        reurl=re.search(r"POST[\s][\S]*",strs)
        if reurl:
            if reurl.group()!="POST /ca_report.cgi":
                repost=re.search(r"[\s][\s][\s][\s][\S]*",strs)
                status=packet[IP].src+"  "+reurl.group()+"  "+repost.group().strip()+"  "
                #post_xss_check(repost.group())
                statuscode.append(str(packet[TCP].sport))
        reurlget=re.search(r"GET[\s][\S]*",strs)
        if reurlget:
            status=packet[IP].src+"  "+reurlget.group()+"  "
            statuscode.append(str(packet[TCP].sport))
        geturl=re.search(r"HTTP/1.1[\s][\d]+[\s]+[\w]+",strs)
        if geturl:
            for stra in statuscode:
                if str(packet[TCP].dport) in stra:
                    statuscode=[]
                    log=status+geturl.group()+"  "+time.strftime('%H:%M:%S',time.localtime(time.time()))
                    status=""
                    if "POST" in log:
                        data=log.split(" ")[5]
                    if "GET" in log:
                        data=log.split(" ")[3].split("?")[1]
                    if "POST" or "GET" in log:
                        threading.Thread(target=check_data,args=(data,log)).start()


#count=int(sys.argv[1])
packet=sniff(filter="tcp port 80",prn=FilterPacket,iface="eth0",count="")
   
