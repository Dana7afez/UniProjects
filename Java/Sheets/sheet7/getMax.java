//Name[DANA MHD BASHAR HAFEZ] ID[443204238] Section[70729]Sheet[7]

//Q2
public class getMax {
public static int getMax(int[] list ){
 int max = list[0] ; 
 
 for( int i = 1 ; i < list.length ; i++)
 if( list[i] > max )
 max = list[i]; 
 
 
 return max ; 
 }
}//end class