-- test.sql: initial build script for 'test' database

-- test.student
DROP TABLE IF EXISTS test.student;
CREATE TABLE test.student(id INT PRIMARY KEY,fname VARCHAR(20),lname VARCHAR(20), major VARCHAR(20));
INSERT INTO test.student (id,fname,lname, major) VALUES
	(1,"Roger","Gee", "CS"),
	(2,"Jonathan","Schouse","CS"),
	(3,"Adam","Starbuck","CS"),
	(4,"Ethan","Waddle","CS");



