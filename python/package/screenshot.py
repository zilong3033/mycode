#encoding:utf-8
from PIL import ImageGrab  #导入截图模块
import time #导入时间模块

class catch:
    def __init__(self,timer,count):
        self.timer=timer    #休眠时间
        self.count=count    #截屏次数
        self.i=0            #计数
    def catchs(self):
        while 1: #循环执行截图
            pic = ImageGrab.grab()  #截图（这就截取好了，是全屏哦）
            timeTemp = time.time() #1970纪元后经过的浮点秒数，得到时间戳
            timeTempNext = time.localtime(timeTemp) #将一个时间戳转换成一个当前时区的struct_time（自己可以看一下这个结构和C++的差不多）
            timeNow = time.strftime("%Y-%m-%d-%H-%M-%S", timeTempNext) #将此时的struct_time，根据指定的格式化字符串输出
            print(timeNow)
            path = "D:\\data\\"
            savePath = path + timeNow + ".jpg"#字符串的合并生产合理的路径
            pic.save(savePath)#保存图片
            self.i=self.i+1
            if self.i==self.count:
                break
            time.sleep(self.timer)#sleep函数的参数是秒级别，因此是sleep一分钟 
            