import java.util.*;
public class Test{
public static void main(String[] args){
Scanner input = new Scanner(System.in);

char ch , choise;
double length , width , radius;

do{
System.out.println("Enter R for rectangle and C for circle");
ch = input.next().charAt(0);

switch(ch){
case 'R' : case 'r':
System.out.println("Entre the length and width of the rectangle");
length = input.nextDouble();
width = input.nextDouble();
//Name[DANA MHD BASHAR HAFEZ] ID[443204238] Section[70729]Sheet[6]

Shape obj1 = new Shape("rectangle", length , width);
CheckShape(obj1);
break;

case 'C' : case 'c':
System.out.println("Entre the radius of the circle ");
radius = input.nextDouble();
Shape obj2 = new Shape("circle" , radius);
CheckShape(obj2);
break;
default:
System.out.println("wrong choice");
} // end switch

System.out.println("Do you want to create other shape Y/N");
choise = input.next().charAt(0);
}while (choise == 'Y'|| choise =='y');

System.out.println("Total number of created shapes is "+ 
Shape.getTotalNumerOfShapes());
} // end main 

public static void CheckShape (Shape sh ){
System.out.printf("area= %.2f Perimeter = %.2f \n", sh.getArea() ,sh.getPerimeter());
System.out.println("The number Of Rectangle is " + Shape.numOfRectangle +
 " and number Of Circle is " + Shape. numOfCircle);
if(sh.getArea() > 100)
System.out.println("Big Shape Size");
else
System.out.println("Small Shape Size");
} // end method 
} // end class