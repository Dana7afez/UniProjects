import java.util.Scanner;
public class passenger_information {
public static void main(String[] args){
Scanner input = new Scanner(System.in);

System.out.println("Enter passenger full name: ");
String name = input.nextLine();

System.out.println("Enter passenger flight number: ");
String flight_number = input.next();

System.out.println("Enter passenger seating: ");
String pass_seat = input.next();

String set_line = pass_seat.substring(0, 1);
String set_num=pass_seat.substring(1);

System.out.println("Enter departure time: ");
int time = input.nextInt();

String boarding = (time-1) + ":30" ; 
int len = name.length() + 4 ; 
String colum2 = "%-" + len + "s" ; 

System.out.printf("%20s"+ colum2 + "%20s" + colum2 + "%n","Passenger Name: " , name 
,"Flight #: " ,flight_number); 

System.out.printf("%20s" + colum2 + "%20s" + colum2 + "%n","Seating Line: ", set_line , 
"Seating #: ",set_num );

System.out.printf("%20s" + colum2 + "%n", "Boarding Time: ", boarding );

}
}