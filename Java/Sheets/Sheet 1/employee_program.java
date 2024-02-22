public class employee_program{
public static void main(String[] args){
final int SALARY_DATE = 28 ;
String name = "Reema Saad" ;
double salary = 8125.5 ;
int date = 10 ; 
int remainDays = SALARY_DATE - date ;
double anuualSal = salary * 12 ;
System.out.println("Employee's name : "+ name);
System.out.println("Employee's monthly salary : "+ salary +" SAR");
System.out.println("day date : " + date);
System.out.println("You will pe getting paid after : "+ remainDays +" days.");
System.out.println("employee annual salary : "+ anuualSal +" SAR");
}
}