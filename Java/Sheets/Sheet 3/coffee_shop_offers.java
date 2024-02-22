import java.util.Scanner ; 
public class coffee_shop_offers {
public static void main(String[] args){
Scanner input = new Scanner(System.in);
double price , Dis = 0 , total_charge = 0;

System.out.print("Enter loyalty level (S for Silver) or (G for Gold): ");
char level = input.next().charAt(0);
System.out.print("Enter the number of beans bags: ");
int bags = input.nextInt();

if( level == 'g' || level == 'G' ) {
price = bags * 5;
if(bags < 10)
Dis=price*0.05;
else
Dis=price*0.20;
}

else
if( level == 's' || level == 'S' ) {
price = bags * 5;
if(bags >= 15)
Dis=price*0.15;
else if(bags > 10)
Dis=price*0.10;
else
Dis=0 ;
}

else
{
System.out.println("invalid input of loyalty level!");
bags = 0 ; 
price = 0 ; 
}//end else
System.out.println();
System.out.println("Number of ordered beans: " + bags);
System.out.printf("Discount value: -%-6.2f SR %n" , Dis);
total_charge = price -Dis;
System.out.printf("Your total charge: %-6.2f SR %n" , total_charge);
}
}
