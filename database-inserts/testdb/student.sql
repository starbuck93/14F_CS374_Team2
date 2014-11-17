DROP TABLE IF EXISTS test.student;
CREATE TABLE test.student(id INT PRIMARY KEY,fname VARCHAR(30), mi VARCHAR(1),lname VARCHAR(30), classification INT, hours INT);


INSERT INTO test.student (id,fname, mi, lname, classification, hours) VALUES
	(1,"Roger", "P","Gee", 3, 65),
	(2,"Jonathan", "L","Schouse", 4,85),
	(3,"Adam", "D", "Starbuck", 3, 65),
	(4,"Ethan", "W",  "Waddle", 4, 85),
	(5,"Bob","Q","Sagot",1,10),
	(6,"Brent","R","Neil",2,11),
    (7,"Ruth","F","Jenkins",1,9);
