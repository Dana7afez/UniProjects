public class TestClass {
 public static void main(String[] args) {

 Alligator a= new Alligator("Alligator_1",360,10,2.7);
 Snake s1= new Snake("Snake_1",100,20);
 Snake s2= new Snake("Snake_2",150,30);
 
 Animal list[]= new Animal[3];
 list [0]=a; 
 list [1]=s1;
 list [2]=s2;
  
 for(int i=0;i<3 ;i++)
 {
 if(list[i] instanceof Alligator)
 {
 if(((Alligator)list[i]).swimsDeep() )
 System.out.println("Alligator swims deep");
 else
  System.out.println("Alligator does not swim deep");
  }
  
  list[i].sleep();
    System.out.println(list[i].toString() );
    
    }//for

  
  

 


















}//main
}//class