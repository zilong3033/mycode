import requests
import json
import time

class AutoSql(object):
    taskid=""
    start_time=0
    def __init__(self,server,target):
        self.server=server
        self.target=target
        
    def task_new(self):
        urls=self.server+"/task/new"
        new_data=requests.get(urls)
        dct=new_data.json()
        self.taskid=dct["taskid"]
        if self.taskid:
            return True
        else:
            return False
  
    def task_delete(self):
        urls=self.server+"/task/"+self.taskid+"/delete"
        data=requests.get(urls)
        dct=data.json()
        if dct["success"]:
            return True
        else:
            return False
    
    def scan_start(self):
        urls=self.server+"/scan/"+self.taskid+"/start"
        target_json=json.dumps({"url":self.target})
        start_data=requests.post(urls,data=target_json,headers={"Content-Type":"application/json"})
        self.start_time=time.time()
        dct=start_data.json()
        if dct["success"]:
            return True
        else:
            return False
    
    def scan_status(self):
        urls=self.server+"/scan/"+self.taskid+"/status"
        status_data=requests.get(urls)
        return status_data.json()["status"]

    def scan_data(self):
        urls=self.server+"/scan/"+self.taskid+"/data"
        result_data=requests.get(urls)
        dct=result_data.json()
        if not dct["data"]:
            print "good,no bug in this website."
        else:   #these data can jump to json
            print "the bug count is %d" % len(dct["data"][1]["value"][0]["data"])
            for i in dct["data"][1]["value"][0]["data"]:
                print "title: "+dct["data"][1]["value"][0]["data"][i]["title"]
                print "payload: "+dct["data"][1]["value"][0]["data"][i]["payload"]
            
    def option_set(self):
        pass
    
    def option_get(self):
        pass

    def option_list(self):
        pass

    def scan_stop(self):
        urls=self.server+"/scan/"+self.taskid+"/stop"
        stop_data=requests.get(urls)
        dct=stop_data.json()
        if dct["success"]:
            return True
        else:
            return False
            
    def scan_kill(self):
        urls=self.server+"/scan/"+self.taskid+"/kill"
        kill_data=requests.get(urls)
        dct=kill_data.json()
        if dct["success"]:
            return True
        else:
            return False
            
    def admin_list(self):
        pass
        
    def scan_log(self):
       pass 
    
    def run(self):
        if not self.task_new():
            return False
        #self.option_get
        if not self.scan_start():
            return False
        while True:
            if self.scan_status()=="running":
                time.sleep(3)
            elif self.scan_status()=="terminated":
                break
            else:
                break
            if time.time()-self.start_time>3000:
                error=True
                self.scan_stop()
                self.scan_kill()
                break
        self.scan_data()
        self.task_delete()
        print time.time()-self.start_time
        
#t=AutoSql("http://127.0.0.1:8775","http://127.0.0.1/3.php?id=1")
#t.run()
               
    