public class students_lockers{
static final double VAT = 0.15 ;
public static void main(String[] args){
String name = "Reema Saad" ;
int id = 4413243 ;
char location = 'G' ;
int numQurters = 3 ;
double price = 24.5 ;
double total = price * numQurters ;
total = total + ( total * VAT ) ; 
System.out.println("Student's name : "+name);
System.out.println("Student's ID : "+id);
System.out.println("locker location : "+location);
System.out.println("number of quarters : "+numQurters);
System.out.println("rental price (per quarter) : "+price);
System.out.println("-----------------------------------------------");
System.out.println("The reservation is confirmed and the total price is "+ total + " SAR" );
}
}