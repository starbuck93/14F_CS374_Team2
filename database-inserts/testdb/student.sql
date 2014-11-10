DROP TABLE IF EXISTS test.student;
CREATE TABLE test.student(id INT PRIMARY KEY,fname VARCHAR(30), mi VARCHAR(1),lname VARCHAR(30), classification INT, hours INT);


INSERT INTO test.student (id,fname, mi, lname, classification, hours) VALUES
	(1,"Roger", "A","Gee", 4, 0),
	(2,"Jonathan", "A","Schouse", 4, 0),
	(3,"Adam", "A", "Starbuck", 4, 0),
	(4,"Ethan", "A",  "Waddle", 4, 0),
	(5,"Fresh","M","An",1,0),
	(6,"Soph","M","Ore",2,0);
