 //Name[DANA MHD BASHAR HAFEZ] ID[443204238] Section[70729]Sheet[7]

 //Q3

public class sort {
public static void main(String[] args) {
int[] list = {9,1,2,5,3,2} ;
System.out.println("original Array : ");
for( int i = 0 ; i < list.length ; i++)
System.out.print( list[i] + " ");
System.out.println("");
// sort 
for( int i = 0 ; i < list.length ; i++){
 int min = i; 
for( int j = i +1 ; j < list.length ; j++)
if( list[j] <= list[min])
 min = j ; 
// swap after finsh from inner loop j 
int temp = list[min] ; 
list[min] = list[i] ; 
list[i] = temp ; 
 
} // ind i 
System.out.println("After sorting: ");
for( int i = 0 ; i < list.length ; i++)
System.out.print( list[i] + " ");
System.out.println("");
}
}