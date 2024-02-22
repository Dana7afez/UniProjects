public class Alligator extends Reptiles{

private double maxDepth;

public Alligator(String N , double w , int a , double m)
{
 super(N,w,a);
 maxDepth=m;
}

public void sleep(){
System.out.println("alligators sleep 6-8h a day \n");

}

public boolean swimsDeep(){
if (maxDepth<4)
return false;
else 
return true;
}

public String toString() {
 return super.toString()+" maxDepth= " + maxDepth  +"\n";  }












}//class