import java.util.Scanner; 
public class average_exercising_time { 
public static void main(String[] args) {
 Scanner input = new Scanner(System.in); 
 
 System.out.println("-- Welcome to your active time calculator --"); 
 System.out.println("how many weeks you have been exercising : "); 
 int numWeek = input.nextInt(); 
 
 int totalHours = 0 ; 
 
 for( int i = 1 ; i <= numWeek ; i++ )
 { System.out.println("week :" + i ); 
 System.out.println("Have you been active this week at all ? (yes - no) "); 
 String ansr = input.next(); 
 if( ansr.equalsIgnoreCase("no")) 
 continue ; 
 
 System.out.println("How long you have been active in hours : "); 
 
 for( int j = 1 ;j <= 7 ; j++)
 { System.out.print("Day " + j + " : "); 
 int hr = input.nextInt(); 
 totalHours = totalHours + hr ; 
 }// end for j 
 }// end for i 
 
 double average = (double)totalHours / ( numWeek * 7 ) ; 
 System.out.printf("-- your average is %.2f hour per day -- \n " , average ); 
 }// end main 
 }// end class 