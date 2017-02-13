#include<stdio.h>
#include<fcntl.h>
#include<error.h>
#include<unistd.h>
#define SIZE 10

void main(int argc,char *argv[])
{
	int fd,num;
	char buf[SIZE];
	fd=open(argv[1],O_RDONLY);
	if(fd==-1)
		perror("open");
	else
	{
		while(read(fd,buf,1))
		{
			buf[1]='\0';
			printf("%s",buf);
		}
	}
	close(fd);
}
