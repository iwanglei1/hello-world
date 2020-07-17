#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <unistd.h>

//数组大小
#define nSize 80
//循环计数
int nCount = 0;

//初始化数据
int InitData()
{
  setvbuf(stdin, 0, 2, 0);
  setvbuf(stdout, 0, 2, 0);
  return 0;
}

//根据循环次数，控制读取长度
int sub_400675(int nLen)
{
  int nReadSize = 0;

  if (nCount == 0)
  {
    nReadSize = nLen + sizeof(long) + 1;
  }
  else if (nCount == 1)
  {
    nReadSize = nLen + sizeof(long) * 4;
  }

  return nReadSize;
}

//漏洞函数
int sub_400676(int nCount)
{
  char buf[nSize];
  memset(buf, 0, sizeof(buf));
  putchar('>');

  int nReadSize = 0;
  nReadSize = sub_400675(nSize);

  int nRet = 0;
  if(nCount==0)
  {
    nRet=1;
  }
  else if(nCount==1)
  {
    nRet=0;
  }
  else
  {
    return 0;
  }
  
  int nRealRead = read(0, buf, nReadSize);

  puts(buf);

  if (nCount == 0)
  {
    *(buf + nRealRead - 1) = 0;
  }
  
  return nRet;
}

int main()
{
  nCount=InitData();
  while (sub_400676(nCount))
  {
    nCount++;
  }
  return 0;
}