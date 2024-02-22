//Name[DANA MHD BASHAR HAFEZ] ID[443204238] Section[70729]Sheet[5]

public class student{
private int ID ; 
private String Name ; 
private double Stipend ; 
private String university ; 
private double GPA ;
 
public void SetInfo(int id, String name, String univ, double gpa)
{
ID=id;
Name=name;
university=univ;
GPA=gpa;

if( gpa >= 4 )  
Stipend = 1000 ; 
else
 Stipend = 900 ;
}

public String getUni()
{return university;}

public void changeGPA(double newGPA)
{
GPA=newGPA;
if(GPA>=4)
Stipend=1000;
else
Stipend=900;
}

public boolean checkSameGPA(student B )
{
if( GPA == B.GPA )
 return true ; 
else
 return false ; 
 }
 
public void PrintInfo()
{
System.out.println("ID : " + ID + " , Name : " + Name );
System.out.println("Stipend : " + Stipend + " , University : " + 
university);
System.out.println("GPA : " + GPA );
}



}//end class