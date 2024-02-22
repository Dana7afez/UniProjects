import java.util.Scanner ;
public class KSU_student
{
public static void main(String[] args)
{
Scanner input = new Scanner(System.in);

String id , name , year;

System.out.println("Enter Student full name and KSU email in the following format:"+
 "firstName lastName_KSUemail ");
String str = input.nextLine();
int loc1 = str.indexOf(" ");

name = str.substring(0 , loc1);
name = name.substring(0,1).toUpperCase().concat( name.substring( 1 )) ;

int loc2 = str.indexOf('_');
int loc3 = str.indexOf('@');

id = str.substring(loc2+1 , loc3);
year = id.substring(0 , 2);

int enrollmentYear = Integer.parseInt(year) ;
enrollmentYear = 1400 + enrollmentYear ; 

System.out.println("First name is "+name);
System.out.println("Student ID is "+id);
System.out.println("The enrollment year in Higri is "+enrollmentYear);
}
}
