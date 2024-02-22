//Name[DANA MHD BASHAR HAFEZ] ID[443204238] Section[70729]Sheet[5]

import java.util.Scanner;
public class TestStudent {
public static void main(String[] args) {
Scanner input = new Scanner(System.in) ; 
student obj1=new student();
student obj2=new student();

obj1.SetInfo(4339999, "Maha mohammed", "KSU", 4.5);
obj2.SetInfo(4338888, "Dema saad", "PSU", 3.9);

if( obj1.getUni().equalsIgnoreCase(obj2.getUni() ))
System.out.println("Both students study at the same university");
else
System.out.println("The two students do not study at the same university");

System.out.println("Enter new GPA for the second student :");
double gpa=input.nextDouble();
obj2.changeGPA(gpa);

if( obj1.checkSameGPA(obj2))
System.out.println("Both students have the same grade");
else
System.out.println("The two students do not have the same grade");

System.out.println("-------------");
System.out.println("obj1 : ");
obj1.PrintInfo();
System.out.println("-------------");
System.out.println("obj2");
obj2.PrintInfo();

}//end main
}//end class


