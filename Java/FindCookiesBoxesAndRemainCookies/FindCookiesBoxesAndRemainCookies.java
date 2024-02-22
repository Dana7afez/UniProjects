// how many box you need for cookies and how many remain cookies(box=36 cookies)

import java.util.Scanner;
public class FindCookiesBoxesAndRemainCookies{
public static void main(String args[]){

Scanner input =new Scanner( System.in) ;
System.out.println( "enter number of cookies");
int num = input.nextInt() ; 

int numBox = num / 36 ;

int remain = num % 36 ;

System.out.println("num of box = " + numBox );

System.out.println("remain cookies with out boxing " + remain );
}
}
