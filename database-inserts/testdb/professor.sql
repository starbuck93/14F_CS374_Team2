drop table if exists test.professor;
create table test.professor(id INT PRIMARY KEY, fname VARCHAR(30), mi VARCHAR(1), lname VARCHAR(30));

INSERT INTO test.professor (id, fname, mi, lname) VALUES
	(1, "Brent", "", "Reeves"),
	(2, "Alfa", "", "Nyandaro"),
	(3, "Brad", "", "Crisp");