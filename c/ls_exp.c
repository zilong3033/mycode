#include<stdio.h>
#include<sys/stat.h>
#include<sys/dir.h>
#include<sys/types.h>
#include<sys/fcntl.h>
#include<error.h>
#include<unistd.h>
#include<pwd.h>
#include<grp.h>
#include<string.h>
#include<time.h>
#define NAME_SIZE 15
#define N_BITS 3
struct fnode
{
	struct fnode *next;
	char name[NAME_SIZE];
};
void main(int argc,char *argv[])
{
	struct stat info;
	struct dirent *entp=NULL;
	struct passwd *user;
        struct group *group;
	DIR *dirp;
	unsigned int i,mask=0700;
        int index;
        static char *perm[]={"---","--x","-w-","-wx","r--","r-x","rw-","rwx"};
        char type[7]={'p','c','d','b','-','l','s'};
	dirp=opendir(".");
        if(dirp==NULL)
	{
		perror("opendir");
	}
	while(entp=readdir(dirp))
	{
		if(entp->d_name[0]=='.')
			continue;
	        if(stat(entp->d_name,&info)!=-1)
		{
			index=((info.st_mode>>12)&0xF)/2;
			printf("%c",type[index]);
			printf("%s",perm[info.st_mode>>6&07]);
			printf("%s",perm[info.st_mode>>3&07]);
			printf("%s ",perm[info.st_mode>>0&07]);
			user=getpwuid(info.st_uid);
			printf("%s ",user->pw_name);
			group=getgrgid(info.st_gid);
                        printf("%s ",group->gr_name);
			printf("%d ",(int)info.st_nlink);
			printf("%8ld ",info.st_size);
			output_time(info.st_mtime);
			printf("%s",entp->d_name);
			printf("\n");
		}
	}
	closedir(dirp);
}
output_time(long mtime)
{
	char buf[256];
        memset(buf,'\0',256);
	ctime_r(&mtime,buf);
        buf[strlen(buf)-1]='\0';
        printf("%s ",buf);
}


