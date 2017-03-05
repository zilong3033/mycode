import zipfile

class hackzip(object):
    "hack zip with dict"
    def __init__(self,filepath,dictpath):
        self.filepath=filepath
        self.dictpath=dictpath

    def zipbp(self,zfile,pwd):
        try:
            zfile.extractall(pwd=pwd)
            print "password is:%s" % pwd
        except:
            pass
    
    def handle(self):
        zfile=zipfile.ZipFile(self.filepath)
        df=open(self.dictpath,'r')
        for pwds in df.readlines():
            pwd=pwds.strip("\n")
            self.zipdp(zfile,pwd)
            
'''
zip's path
dict's path'''
            