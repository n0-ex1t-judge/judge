#include <iostream>
#include <cstdio>
using namespace std;

int main(int argc , char* argv[]){
  FILE* contestant = fopen(argv[2] , "r");
  FILE* author = fopen(argv[3] , "r");
  int a , b;
  fscanf(contestant , "%d" , &a);
  fscanf(author , "%d" , &b);
  return (a==b) ? 0 : 1;
}
