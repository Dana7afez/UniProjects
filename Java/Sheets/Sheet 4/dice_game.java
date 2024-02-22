import java.util.Scanner; 
public class dice_game {
 public static void main(String[] args) { 
 Scanner input = new Scanner(System.in) ; 
 
 int sumSara = 0 ,sumNoura = 0 ; 
 int dice1 , dice2 ; 
 int num6Dice1 = 0 , num6Dice2 = 0 ; 
 boolean exchange = false; 
 
 System.out.println("Let's play"); 
 System.out.println("Enter number of rounds : "); 
 int round = input.nextInt(); 
 
 for( int i = 1 ; i <= round ; i++){ 
 System.out.println("Enter Sarah's then Norah's numbers ( 1 - 6 ) : "); 
 
 if( exchange == false ){ 
 dice1 = input.nextInt(); 
 dice2 = input.nextInt(); 
 sumSara += dice1 ; 
 sumNoura += dice2 ; } 
 else 
 { dice2 = input.nextInt(); 
 dice1 = input.nextInt(); 
 sumSara += dice2 ; 
 sumNoura += dice1 ; } 
 
 if( sumSara != sumNoura )
 { exchange = !exchange ; 
 System.out.println("Exchange"); } 
 if( dice1 == 6 ) 
 num6Dice1++; 
 if( dice2 == 6 ) 
 num6Dice2++; } 
 // end for
 
  if( num6Dice1 > num6Dice2 ) 
  System.out.println("dice1 is rigged "); 
  else if( num6Dice2 > num6Dice1 ) 
  System.out.println("dice2 is rigged "); 
  else System.out.println("dice1 and dice1 are equals"); 
  }// end main 
  }// end class