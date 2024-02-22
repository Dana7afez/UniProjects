//Read seconds from user then find how many Hours , minuts and seconds

import java.util.Scanner;
public class InputSecondsFindHoursMinutesSeconds{
public static void main(String args[]){

Scanner input =new Scanner( System.in) ;
System.out.println( "enter number of seconds");
int sec = input.nextInt() ; 

int hr = sec / 3600 ;
sec = sec % 3600 ; 

int min = sec / 60 ; 
sec = sec % 60 ; 

System.out.println(hr + ":" + min + ":" + sec );
}
}
