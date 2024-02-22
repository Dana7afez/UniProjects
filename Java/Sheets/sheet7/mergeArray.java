//Name[DANA MHD BASHAR HAFEZ] ID[443204238] Section[70729]Sheet[7]

//Q4
public class mergeArray {
public static void main(String[] args) {
String[] a = { "Ahmad", "Adam" }; 
String[] b = { "Mick", "Ali" }; 
String[] array = new String[a.length + b.length ]; 
int i = 0; 
for( int j = 0 ; j < a.length ; j++)
array[i++] = a[j] ; 
for( int j = 0 ; j < b.length ; j++)
array[i++] = b[j] ; 
System.out.println("Merg Array : ");
for( i = 0 ;i < array.length ; i++ )
System.out.print( array[i] + " ");
System.out.println("");
}
}