public abstract class Reptiles extends Animal {
private int amountOfPlants;

public Reptiles(String N , double w , int a)
{
 super(N,w);
 amountOfPlants=a;
}

public String toString() {
 return super.toString()+" amountOfPlants=" + amountOfPlants+ "\n" ;  }
 
 }//class


















