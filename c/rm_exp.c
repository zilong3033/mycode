#include<stdio.h>
#include<unistd.h>
#include<error.h>

void main(int argc,char *argv[])
{
	if(unlink(argv[1])==-1)
		perror("unlink");	
}
