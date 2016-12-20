from scapy.all import *
import sys,re,time

statuscode=[]
status=""
def FilterPacket(packet):
    global statuscode,status
    if packet[TCP].payload:
        strs=str(packet[Raw])
        reurl=re.search(r"POST[\s][\S]*",strs)
        if reurl:
            if reurl.group()!="POST /ca_report.cgi":
                repost=re.search(r"[\s][\s][\s][\s][\S]*",strs)
                status=packet[IP].src+"  "+reurl.group()+"  "+repost.group().strip()+"  "
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
                    print status+geturl.group()+"  "+time.strftime('%H:%M:%S',time.localtime(time.time()))
                    status=""


#count=int(sys.argv[1])
packet=sniff(filter="tcp port 80",prn=FilterPacket,iface="eth0",count="")
   
