//Name[DANA MHD BASHAR HAFEZ] ID[443204238] Section[70729]Sheet[7]

//Q1
public class reversArray {
 public static void main(String[] args) {
int[] list = {1,2,3,4,5,6,7,8,9,10 } ;
 System.out.println("original Array : ");
 for( int i = 0 ; i < list.length ; i++)
 System.out.print( list[i] + " ");
 
 System.out.println("");
 
// revers Array : 
for( int i = 0 , j = list.length -1 ; i < list.length / 2 ; i++ , j--
)
{
 int temp = list[i] ; 
 list[i] = list[j] ; 
 list[j] = temp ; 
}
System.out.println("Reversed Array: ");
 for( int i = 0 ; i < list.length ; i++)
 System.out.print( list[i] + " ");
 
 System.out.println("");
 }
 
}
 


