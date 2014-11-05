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




