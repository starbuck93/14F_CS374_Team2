drop table if exists test.professor;
create table test.professor(id INT PRIMARY KEY, fname VARCHAR(30), mi VARCHAR(1), lname VARCHAR(30));

INSERT INTO test.professor (id, fname, mi, lname) VALUES
	(1, "Brent", "N", "Reeves"),
	(2, "Alfa", "A", "Nyandaro"),
	(3, "Brad", "A", "Crisp"),
    (4, "John", "D", "Homer");
