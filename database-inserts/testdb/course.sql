drop table if exists test.course;
create table test.course(id INT PRIMARY KEY, department VARCHAR(20), course_number INT, name VARCHAR(120), credit_hours INT );

INSERT INTO test.course (id, department, course_number, name, credit_hours) VALUES
	(1, "CS", 101, "Introduction to Computer Science", 3),
	(2, "CS", 374, "Principles of Software Engineering", 3),
	(3, "IT", 202, "Introduction to Computer Networking", 3),
	(4, "DET", 202, "Mobile Computing 2", 3),
    (5, "IS", 110, "Introduction to Information Systems", 3);
