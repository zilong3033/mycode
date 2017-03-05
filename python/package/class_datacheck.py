import urlparse

class Datacheck(object):
    def __init__(self,data):
        self.data=data
        
    def deal_data(self):
        #content=dict([item.split("=") for item in self.data.split("&")])
        content=str(self.data)
        return content
    
    def xsscheck(self):
        xss_data=["script","alert","document","cookie","javascript","onclick",'onsubmit', 'onunload',"fromCharCode","<",">"]
        data=self.deal_data()
        for xssstr in xss_data:
            if xssstr in data.lower():
                return True
        return False
     
    def sqlcheck(self):
        sql_data=["select","and","/*","*/","+","union","order","where","'","from","sleep","concat","group","floor","extractvalue","updatexml","name_const","geometrycollection","multipoint","polygon","linestring","multilinestring","exp","count","--","insert","update","delete"]
        data=self.deal_data()
        for sqlstr in sql_data:
            if sqlstr in data.lower():
                return True
        return False

p=Datacheck("pwd=123456&name=wwqwe&sdajhs=scrScriptipselectt")
print p.xsscheck()
print p.sqlcheck()

