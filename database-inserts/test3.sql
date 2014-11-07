--Entities Created: Student, Building, Room, Dow, Professor, Section, Student-Section, Course

--Entities not yet created: Office-Hours-Assignment, Office-Hours, 

--Foreign keys and other relationships have not been started.


/*

This is a more realistic set of tables than the first tests.  

Tables are created according to the Relationships Beta diagram in the Design folder.



*/

DROP TABLE IF EXISTS test.student;
CREATE TABLE test.student(id INT PRIMARY KEY,fname VARCHAR(30), mi VARCHAR(1),lname VARCHAR(30), classification INT, hours INT);

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

---

We DO NOT use foreign keys to designate the building.  

A building can have multiple rooms.  The entity Building maps 1:M onto Room.

*/


drop table if exists test.professor;
create table test.professor(id INT PRIMARY KEY, first_name VARCHAR(30), middle_initial VARCHAR(1), last_name VARCHAR(30));

/*creates a table based on the entity Professor:
id(key) (id)
first-name (first_name)
middle-initial (middle_inital)
last-name (last_name)
*/


/*
According to the Schema, COURSE is not a "course" as in subject, like CS101, but an instantiation of that subject with an instructor, e.g. CS101-Taught-By-[professor ID]

*/

--time format will be an integer version Military/Internation time.
--for example, 3 am is 300, noon is 1200, 1:00 PM is 1300, midnight is 0.
drop table if exists test.student-section;
create table test.student-section (studentID INT, sectionID INT);
/*create the entity student-section, the students in each given section, with the following attributes:
studentID 
sectionID
--a student takes multiple courses and thus multiple sections, so the same studentID will appear more than once.  Therefore, it can't be a primary key.
*/


drop table if exists test.section;
create table test.section(sectionID INT PRIMARY KEY, crn INT, section_number INT, time INT, duration INT, DOW VARCHAR(7), room_id INT);
/*
THe sections for each course, with the following attributes:
ID
course ID (CRN)
section_number
time
duration
Days Of Week on which the section meets
room ID (room_ID)
*/

drop table if exists test.course;
create table test.course(crn INT PRIMARY KEY, department VARCHAR(20), course_number INT, professor_id INT, name VARCHAR(30) );


/*Creates the entity Course, with the following attributes:
course ID (crn)
department
course_number (such as 101, for the course CS 101)
professor_id (ID of the instructor, from entity Professor
course name (name)

*/
