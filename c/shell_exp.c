#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <stdlib.h>
#include <sys/wait.h>
#include <grp.h>
#include <string.h>
#include <pwd.h>
#include <libgen.h>
#include <sys/types.h>
#include "ls_exp.h"
#include "cat_exp.h"
#define CMDNUM 100
 
struct PRO{
        int p_num;
        char p_name[20];
        pid_t p;
        int state;
} process[100];
 
int Analyse(char cmd[],char *arg[],char buf[]);
int func_choice(char cmd[],char *arg[]);
int Echo(char *arg[]);
int Cd(char *arg[]);
int Pwd(char *arg[]);
int JobList();
int Record(char cmd[],pid_t p);
int Now=0;
 
int main()
{
        int i;
        char path[1024],*username,host[100],tmp[80];
        struct group *data;
        
        char *arg[100],cmd[100],buf[200];
        data=getgrgid(getgid());
    username=data->gr_name;
    strcat(tmp,username);
        for(i=0;i<100;i++){
                process[i].p_num=0;
                process[i].state=0;
        }//初始化进程记录数组
        //////存入父进程
        process[0].p_num = 1;
        strcpy(process[0].p_name,"minish");
        process[0].p=getpid();
        process[0].state = 1;
        while(1){
            Now = 0;
        if(gethostname(host, 99) == -1) {
            strcpy(host, "localhost");
        }
/*        if(!getcwd(path, 99)) {
            strcpy(path, "unknown");
        } else {
            if(strcmp(path, "/")!= 0)
                strcpy(path, basename(path));
        } */
        if( getcwd(path,1024) == NULL)
              printf("获取路径失败！\n");
        if(strcmp(username,"root")==0)//判断是否为超级用户
            printf("%s@%s:[%s]# ",username,host,path);
        else printf("%s@%s:[%s]$ ",username,host,path);
        if( (fgets(buf,200,stdin)!=NULL) && (*buf != '\n') ){
                buf[strlen(buf)-1] = '\0';
            if(buf[strlen(buf)-2] == '&') Now=1;
            if( !strcmp(buf,"quit") || !strcmp(buf,"exit") || !strcmp(buf,"bye"))
                    return 0;
            Analyse(cmd,arg,buf);
                func_choice(cmd,arg);
         }
 
       }
       return 0;
}

//命令解析
int Analyse(char cmd[],char *arg[],char str[])
{
        int i=0;
        char *p=NULL;
        while( (p = strsep(&str," ")) != NULL)
        {
                if(i==0)
                        strcpy(cmd,p);
                arg[i++]=p;
        }
        if( !strcmp(arg[i-1],"&"))
        {
                arg[i-1] = '\0';
                Now=1;
        }
        else
                arg[i]=NULL;
        return 0;
}

/*根据输入指令执行相应程序*/
int func_choice(char cmd[],char *arg[])
{
 
//        int i;
        pid_t pid;
        //内部命令
        if( !strcmp(cmd,"echo"))
                Echo(arg);
        else if( !strcmp(cmd,"cd"))
                Cd(arg);
        else if( !strcmp(cmd,"ls"))
                Ls(arg);
        else if(!strcmp(cmd,"cat"))
                Cat(arg);
        else if(!strcmp(cmd,"pwd"))
            Pwd(arg);
        else//外部命令  
        {
                pid = fork();
                if( pid > 0)
                {
                        Record(cmd,pid);
                }
                if( pid < 0 )
                {
                        printf("fork error\n");
                }
                if(pid == 0)
                {
                         if( (execvp(cmd,arg)) < 0 )
                                         printf(" 文件或目录不存在！\n");
                         else
                         {
                                Record(cmd,pid);
 
                         }
                }
        }
 
        if(Now)
                 waitpid(pid,0,WNOHANG);
        else
                waitpid(pid,0,0);
        return 0;
}

//cd：修改当前的工作目录到另一个目录
int Cd(char *arg[])
{
        if( chdir(arg[1]))
            printf("目录不存在！");
        return 0;
}

//pwd：显示当前的所在的工作目录
int Pwd(char *arg[])
{
    char path[1024];
    if( getcwd(path,1024) == NULL)
                printf("获取路径失败！\n");
                printf("**%s**\n",path);
        return 0;
}

//Echo：显示echo后的内容且换行
int Echo(char *arg[])
{
         int i=1;
         while(arg[i] != NULL)
        {
                printf("%s ",arg[i++]);
        }
        printf("\n");
        return 0;
}

//env
int Ls(char *arg[])
{
    lsxp(arg);
}

int Cat(char *arg[])
{
    Catxp(arg);
}
//记录
int Record(char cmd[],pid_t p)
{
        int i;
 
        for(i=0;i<100;i++)
        {
                if(process[i].state != 1)
                {
                        strcpy(process[i].p_name,cmd);
                        process[i].state = 1;
                        if(p>0) process[i].p = p;
                        break;
                }
        }
        return 0;
}
