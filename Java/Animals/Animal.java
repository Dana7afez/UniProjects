public abstract class Animal {

private String name; 
protected double weight ; 

public Animal(String N , double w)
{
 name = N ; 
 weight = w ; 
}

public abstract void sleep();

public String toString() {
 return "name=" + name + ", weight=" + weight ;  }
 



}//class