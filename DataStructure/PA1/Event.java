import java.util.Date;

/*
Event: This class will represent events or appointment that can be scheduled with a contact. 
It should have fields for the event title, date and time, location, and the contact involved in this event.
*/

public class Event implements Comparable<Event> {
    String title;
    Date date;
    String time;
    String location;
    LinkedList <String> contacts_names;

    public Event() {
        this.title = "";
        this.date = null;
        this.time = "";
        this.location = "";
        this.contacts_names = new LinkedList<String> ();
    }
    
    public Event(String title, String date, String time, String location, String contact) {
        this.title = title;
        this.date = new Date(date);
        this.time = time;
        this.location = location;
        this.contacts_names = new LinkedList<String> ();
        contacts_names.insertSort(contact);
    }

    public boolean addContact (String contact)
    {
        return contacts_names.insertSort(contact);
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
        String str = "\nEvent title: " + title +
                    "\nEvent date and time (MM/DD/YYYY HH:MM): " + date + time +
                   "\nEvent location: " + location + "\n" +
                    "\nContacts names:   " ;
                
        contacts_names.findFirst();
         for ( int i = 0 ; i < contacts_names.size ; i++ )
         {
             str += contacts_names.retrieve() + "\t";
             contacts_names.findNext();
         }
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

}
