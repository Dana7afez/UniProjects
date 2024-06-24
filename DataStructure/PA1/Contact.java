import java.util.Date;

/*
Contact: This class will represent a single contact in the phonebook. It should have fields for the 
contact’s name, phone number, email address, address, birthday, and notes. */

/**
 
public class Contact implements Comparable<Contact> {
    String name;
    String phonenumber;
    String emailaddress;
    String address;
    Date birthday; 
    String notes;
    LinkedList<Event> events ; 
   
    public Contact() {
        this.name = "";
        this.phonenumber = "";
        this.emailaddress = "";
        this.address = "";
        this.birthday = null;
        this.notes = "";
        events = new LinkedList<Event>();
    }

    public Contact(String name, String phonenumber, String emailaddress, String address, String birthday, String notes) {
        this.name = name;
        this.phonenumber = phonenumber;
        this.emailaddress = emailaddress;
        this.address = address;
        this.birthday = new Date(birthday);
        this.notes = notes;
        events = new LinkedList<Event>();
    }

    @Override
    public String toString() {
        return "\nName: " + name +
                    "\nPhone Number: " + phonenumber +
                    "\nEmail Address: " + emailaddress +
                    "\nAddress: " +  address +
                    "\nBirthday: " + birthday +
                    "\nNotes: " + notes + "\n";
    }

    public boolean addEvent( Event e)
    {
        if (! events.empty())
        {
            events.findFirst();
            for ( int i = 0 ; i < events.size ; i++)
            {
                if ((events.retrieve().date.compareTo(e.date) == 0) 
                        && (events.retrieve().time.compareTo(e.time) == 0))
                    return false;
            }
      }
    events.insertSort(e);
    return true;
    }

    public boolean removeEvent( String eTitle)
    {
        if (events.empty())
            return false;
       Event val = new Event();
       val.title = eTitle;
        if (events.search(val))
        {
            events.remove(val);
            return true;
        }
        return false;
    }
    
    @Override
    public int compareTo(Contact o) {
        try {
            return (this.name.compareTo(o.name));
        }
        catch (Exception e)
        {
             //To change body of generated methods, choose Tools | Templates.
            throw new UnsupportedOperationException("Not supported yet.");
        }
    }


}
