#encoding:utf-8
from PIL import ImageGrab  #�����ͼģ��
import time #����ʱ��ģ��

class catch:
    def __init__(self,timer,count):
        self.timer=timer    #����ʱ��
        self.count=count    #��������
        self.i=0            #����
    def catchs(self):
        while 1: #ѭ��ִ�н�ͼ
            pic = ImageGrab.grab()  #��ͼ����ͽ�ȡ���ˣ���ȫ��Ŷ��
            timeTemp = time.time() #1970��Ԫ�󾭹��ĸ����������õ�ʱ���
            timeTempNext = time.localtime(timeTemp) #��һ��ʱ���ת����һ����ǰʱ����struct_time���Լ����Կ�һ������ṹ��C++�Ĳ�ࣩ
            timeNow = time.strftime("%Y-%m-%d-%H-%M-%S", timeTempNext) #����ʱ��struct_time������ָ���ĸ�ʽ���ַ������
            print(timeNow)
            path = "D:\\data\\"
            savePath = path + timeNow + ".jpg"#�ַ����ĺϲ����������·��
            pic.save(savePath)#����ͼƬ
            self.i=self.i+1
            if self.i==self.count:
                break
            time.sleep(self.timer)#sleep�����Ĳ������뼶�������sleepһ���� 
            