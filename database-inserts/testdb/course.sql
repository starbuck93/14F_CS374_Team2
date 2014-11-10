drop table if exists test.course;
create table test.course(crn INT PRIMARY KEY, department VARCHAR(20), course_number INT, name VARCHAR(30), credit_hours INT );

INSERT INTO test.course (crn, department, course_number, name, credit_hours) VALUES
	(1, "CS", 101, "Intro to CS", 3),
	(2, "CS", 374, "Software Engineering", 3),
	(3, "IT", 202, "Networking", 3),
	(4, "DET", 182, "Mobile Computing 2", 3);