/*

This is a more realistic set of tables than the first tests.  

Tables are created according to the Relationships Beta diagram in the Design folder.



*/

DROP TABLE IF EXISTS test.student;
CREATE TABLE test.student(id INT PRIMARY KEY,fname VARCHAR(20), mi VARCHAR(1),lname VARCHAR(20), classification INT, hours INT);

/*create a table based on the entity Student:

id 

first-name (fname)

middle-initial (mi)

last-name (lname)

classification (which should fall within the range 1-4 inclusive: 1 for freshmen, 4 for seniors).

hours

*/

INSERT INTO test.student (id,fname, mi, lname, classification, hours) VALUES
	(1,"Roger", "A","Gee", "CS", 4, 0),
	(2,"Jonathan", "A","Schouse","CS", 4, 0),
	(3,"Adam", "A", "Starbuck","CS", 4, 0),
	(4,"Ethan", "A",  "Waddle","CS", 4, 0);


DROP TABLE IF EXISTS test.dow;
CREATE TABLE test.dow(id INT PRIMARY KEY, days VARCHAR(7));

/*creates a table based on the entity Dow:
id(key)
days   --can be "", "NMTWRFS", etc.  For Sections, it will be either "MWF" or "TR".  If there is a match between a character in the days string for one and the days string for another, they are on the same day.
*/

DROP TABLE IF EXISTS test.building;
CREATE TABLE test.building(id INT PRIMARY KEY, name VARCHAR(30), abbrv VARCHAR(4));
INSERT INTO test.building (id, name, abbrv) VALUES
	(1, "Mabee Business Building", "MBB")
	(2, "Foster Science Building", "FSB");


/*creates a table based on the entity Building:
id(key)
name
abbrv

--
name is the string containing the building's full title: "Mabee Business Building", not "Mabee" or "COBA" or "Business Building"

abbrv is the building's abbreviated string designation with no spaces that you see on the campus map.  For example, Foster Science Building-> "FSB", Mabee Business Building-> "MBB".
*/


drop table if exists test.room;
create table test.room(id INT PRIMARY KEY, room_number INT, building_id INT, has_lab INT);

insert into test.room (id, room_number, building_id, has_lab) VALUES
	(1, 314, 1, 0)
	(2, 315, 1, 0)
	(3, 210, 1, 0)
	(4, 201, 1, 0); 
/*creates a table based on the entity Room:
id(key)
room number (room_number)
building-id (building_id)
has-lab (has_lab)


---

Since MySQL can't do Boolean variables, we use integers: 0 for False, 1 for True

*/
