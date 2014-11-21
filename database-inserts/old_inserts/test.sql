-- test.sql: initial build script for 'test' database

-- test.student
DROP TABLE IF EXISTS test.student;
CREATE TABLE test.student(id INT PRIMARY KEY,fname VARCHAR(20),lname VARCHAR(20));
INSERT INTO test.student (id,fname,lname) VALUES
	(1,"Roger","Gee"),
	(2,"Jonathan","Schouse"),
	(3,"Adam","Starbuck"),
	(4,"Ethan","Waddle");
