-- test.sql: initial build script for 'test' database

-- test.student

---note that Ethan's server username is ethan   all lowercase.  Password is Waddle.


DROP TABLE IF EXISTS test.student;
CREATE TABLE test.student(id INT PRIMARY KEY,fname VARCHAR(20),lname VARCHAR(20), major VARCHAR(20));
INSERT INTO test.student (id,fname,lname, major) VALUES
	(1,"Roger","Gee", "CS"),
	(2,"Jonathan","Schouse","CS"),
	(3,"Adam","Starbuck","CS"),
	(4,"Ethan","Waddle","CS");



--test.class
DROP TABLE IF EXISTS test.class;
CREATE TABLE test.class(id INT PRIMARY KEY, prof1name VARCHAR(20), profLname VARCHAR(20), days VARCHAR(3), course VARCHAR(5), coursenumber INT, section INT);
INSERT INTO test.class (id, prof1name, profLname, days, course, coursenumber, section) VALUES
	(1, "John", "Smith", "MWF", CS, 101, 1),
	(2, "John", "Smith", "TR", CS, 101, 2),
	(3, "John", "Doe", "TR", CS, 101, 3),
	(4, "John", "Doe", "MWF", CS, 101, 4),



--test.class
DROP TABLE IF EXISTS test.class;
CREATE TABLE test.class(id INT PRIMARY KEY, prof1name VARCHAR(20), profLname VARCHAR(20), days VARCHAR(3), course VARCHAR(5), coursenumber INT, section INT);
INSERT INTO test.class (id, prof1name, profLname, days, course, coursenumber, section) VALUES
	(1, "John", "Smith", "MWF", CS, 101, 1),
	(2, "John", "Smith", "TR", CS, 101, 2),
	(3, "John", "Doe", "TR", CS, 101, 3),
	(4, "John", "Doe", "MWF", CS, 101, 4),


