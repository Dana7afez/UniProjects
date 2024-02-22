//Print num of 3 digit in revers order : 
import java.util.Scanner;
public class ThreeDigitsReversOrder{
public static void main(String args[]){

Scanner input =new Scanner( System.in) ;
System.out.println( "Enter number of 3 digit");
int num = input.nextInt() ;

int n1 = num % 10 ;
num = num / 10 ;
 
int n2 = num % 10 ;
num = num / 10 ; 

int n3 = num % 10 ;
num = num / 10 ;

System.out.println( n1 + " " + n2 + " " + n3 ) ; } }