//Name[DANA MHD BASHAR HAFEZ] ID[443204238] Section[70729]Sheet[6]

public class Shape{
private String name;
private double area;
private double perimeter ; 
public static int numOfCircle;
public static int numOfRectangle;

public Shape (String n){
name = n ; }

public Shape (String n, double length, double width){
name = n ; 
calculateArea(length,width);
calculatePerimeter(length,width);
numOfRectangle++;
}

public Shape (String n, double radius){
name = n ;
calculateArea(radius);
calculatePerimeter(radius);
numOfCircle++;
}

public void setName(String n){
name = n ; 
}

public void calculateArea(double length, double width ){
area = length * width ;
}

public void calculateArea(double radius){
area = Math.pow(radius,2) * Math.PI ;
}

public void calculatePerimeter(double length, double width ){
perimeter = ( length + width) * 2 ;
}

public void calculatePerimeter(double radius ){
perimeter = 2 * radius * Math.PI ;
}

public String getName(){
return name ; }

public double getArea(){
return area ; }

public double getPerimeter (){
return perimeter ; }

public boolean equals(Shape shape){
if(area == shape.area && perimeter == shape.perimeter)
return true;
else
return false;
}

public static int getTotalNumerOfShapes(){
return numOfCircle + numOfRectangle ;
}
}
