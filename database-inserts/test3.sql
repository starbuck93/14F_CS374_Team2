--Entities Created: Student, Building, Room, Dow, Professor, Section, Student-Section, Course

--Entities not yet created: Office-Hours-Assignment, Office-Hours, 

--Foreign keys and other relationships have not been started.

--Joins, etc. will be implemented after tentative tables have been created.

/*

This is a more realistic set of tables than the first tests.  

Tables are created according to schema.txt in the Design folder, NOT the Beta Entity Relationship Diagram.  */

/*

Intersection Data:
------------------
student-section
office-hours-assignment

STUDENT has many SECTIONs                   SECTION has many STUDENTs
PROFESSOR has many SECTIONs                 SECTION has a PROFESSOR
COURSE has many SECTIONs                    SECTION has a COURSE
SECTION has a ROOM                          ROOM has many SECTIONs
BUILDING has many ROOMs                     ROOM has a BUILDING
PROFESSOR has many OFFICE-HOURs             OFFICE-HOUR has a ROFESSOR

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


DROP TABLE IF EXISTS test.DOW;
CREATE TABLE test.DOW(id INT PRIMARY KEY, days VARCHAR(7));

/*creates a table based on the entity Days Of the Week (DOW):
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
insert into test.professor (id, first_name, middle_initial, last_name) values
(1, "Reeves", "A", "Brent")
(2, "Homer", "D", "John");

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

insert into test.student-section (studentID, sectionID) values
(1, 1)
(2, 1)
(3, 1)
(4, 1)
(1, 2);

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
insert into test.section (sectionID, crn, section_number, time, duration, DOW, room_ID) values

(1, 1, 1, 1000, 80, "TR", 1)
(2, 1, 2, 1300, 50, "MWF", 2);

drop table if exists test.course;
create table test.course(crn INT PRIMARY KEY, department VARCHAR(20), course_number INT, professor_id INT, name VARCHAR(30) );


/*Creates the entity Course, with the following attributes:
course ID (crn)
department
course_number (such as 101, for the course CS 101)
professor_id (ID of the instructor, from entity Professor
course name (name)

*/

insert into test.course (crn, department, course_number, professor_id, name) values
(1, "Computer Science", 101, 1, "CS101")
(2, "Information Technologies",101, 2, "IT101") 
drop table if exists test.Office-Hours;
create table test.Office-Hours (id INT PRIMARY KEY, duration INT, DOW VARCHAR(3), room_id INT);
/*
office-hours
------------
id (key)
time                    --start time
duration                --integer minutes
dow                     --string: "M" "MWF" "MW" "TR"
room-id                 --(maps to building)


*/

drop table if exists test.Office-Hours-Assignment;
create table test.Office-Hours-Assignment (professor-id INT, office-hourse-id INT primary key);
/*
office-hours-assignment            --intersection data for office-hours and professor
-----------------------
professor-id                            
office-hours-id (key)     -- this MUST be sole primary key so that only one professor may be assigned to an office-hours entity


*/





