#encoding:utf-8
import requests
import urllib
from bs4 import BeautifulSoup
from class_sqlmap_autoapi import AutoSql

'''url="http://web.zilong3033.cn:88"
server="http://127.0.0.1:8775"
def  handle(htmls):
    soup=BeautifulSoup(htmls,"lxml")
    for child in soup.find_all('a'):
        link=child.attrs['href']
        if "http" not in link:
            link=url+"/"+link
            print link
            t=AutoSql(server,link)
            t.run()
 
htmls=requests.get(url)
if htmls.status_code==200:
    handle(htmls.text)'''

class Check_url(object):
    "use sqlmapapi check url"
    
    def __init__(self,server,target):
        self.server=server
        self.target=target
    
    def deal_html(self,htmls):
        soup=BeautifulSoup(htmls,"lxml")
        for child in soup.find_all('a'):
            link=child.attrs['href']
            if "http" not in link:
                link=url+"/"+link
                print link
                t=AutoSql(self.server,link)
                t.run()

    def handle(self):
        htmls=requests.get(self.target)
        if htmls.status_code==200:
            self.deal_html(htmls.text)

'''task=Check_url(server,url)
task.handle()'''