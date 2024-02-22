import java.util.Date;

/*
Event: This class will represent events or appointment that can be scheduled with a contact. It 
should have fields for the event title, date and time, location, and the contact involved in this 
event.
*/

public class Event implements Comparable<Event> {
    String title;
    Date date;
    String time;
    String location;
    boolean EventType;  // event true , appointment = false;
    LinkedList <String> contacts_names;

    public Event() {
        this.title = "";
        this.date = null;
        this.time = "";
        this.location = "";
        this.EventType = true;
        this.contacts_names = new LinkedList<String> ();
    }
    
    public Event(String title, String date, String time, String location, boolean t, String contact) {
        this.title = title;
        this.date = new Date(date);
        this.time = time;
        this.location = location;
        this.EventType =t;
        this.contacts_names = new LinkedList<String> ();
        contacts_names.insert(contact);
    }

    public boolean addContact (String contact)
    {
        if ((this.EventType == true) || ((this.EventType == false)&&(contacts_names.size == 0)))
            return contacts_names.insert(contact);
        
        System.out.println("Could not add more than contact for an appoinment");
        return false;
    }

    public boolean removeContact(String contact)
    {
            String name = contacts_names.remove(contact);
            if ( name != null)
                return true; 
            return false;
    }
 
    @Override
    public String toString() {
        String EventT = (this.EventType == true)? "Event ": "Appoinment ";     
        String str = "\n" + EventT + " title: " + title +
                    "\n " + EventT + "  date and time (MM/DD/YYYY HH:MM): " + date + time +
                   "\n" + EventT + " location: " + location +
                   "\nType: " + EventT +
                    "\nContacts names:   \n" + contacts_names.toString();
                
          return str;
    }
    
    
    @Override
    public int compareTo(Event obj) {
        try {
            return (this.title.compareToIgnoreCase(obj.title));
        }
        catch (Exception e)
        {
             //To change body of generated methods, choose Tools | Templates.
            throw new UnsupportedOperationException("Not supported yet.");
        }
    }

    public boolean compareToSameEvent(Event obj) {
        try {
            return ((this.title.compareToIgnoreCase(obj.title) == 0) && 
                    (this.date.compareTo(obj.date) == 0) &&
                    (this.time.compareToIgnoreCase(obj.time) == 0) && (this.EventType == obj.EventType));
        }
        catch (Exception e)
        {
             //To change body of generated methods, choose Tools | Templates.
            throw new UnsupportedOperationException("Not supported yet.");
        }
    }
    
}
