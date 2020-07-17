#include <stdlib.h>
#include <stdio.h>
#include <string.h>

int fun1(char* buff, char * buff2)
{
	int i;
	int j;
	for(i=0; i<4; i++)
	{
		char temp[4];
		for(j=0; j<4; j++)
		{
			temp[j]=buff[i+j*4];
		}
		for(j=0; j<4; j++)
		{
			char bl, cl, dl, al;
			if(temp[j]<0)
			{
				bl = (temp[j]*2)^0x1B;
			}
			else
			{
				bl = temp[j]*2;
			}

			if(temp[(j+1)%4]<0)
			{
				cl=temp[(j+1)%4]^((temp[(j+1)%4]*2)^0x1B);
			}
			else
			{
				cl=temp[(j+1)%4]^(temp[(j+1)%4]*2);
			}

			dl = temp[(j+2)%4];
			al = temp[(j+3)%4];
			al = al^dl^cl^bl;
			buff[i+4*j] = al;
		}
	}

	for(i=0; i<4; i++)
	{
		for(j=0; j<4; j++)
		{
			buff2[4*i+j]=buff[4*j+i];
		}
	}

	/*
	for (i = 0; i < 4; i++)
	{
	    printf("%08x\n", *(int*)&buff2[i*4]);
	}*/
}



int main(int argc, char **argv)
{
	char buff[17];
	buff[16]='\x00';
	char buff3[16];
	char buff2[16]="ropchain_is_g00d";
	*(int*)buff = 0x6c0f2564;
	*(int*)&buff[4] = 0xde8a2320;
	*(int*)&buff[8] = 0xe1a50e10;
	*(int*)&buff[12] = 0x53113743;
	for(int i = 0; i < 16; i++)
	{
		buff[i] = buff[i]^i;
	}
	for(int i = 0; i < 7; i++)
	{
		fun1(buff, buff3);
		memcpy(buff, buff3, 16);
	}
	printf("ctf{%s}\n", buff);
}
