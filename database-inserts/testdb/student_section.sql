drop table if exists test.student_section;
create table test.student_section(student_id INT, section_id INT, PRIMARY KEY(student_id, section_id));

INSERT INTO test.student_section (student_id, section_id) VALUES
	(1,15000),
	(2,15000),
	(3,15000),
	(4,15000),
	(2,15002),
	(5,15002),
	(6,15002),
	(5,15003),
	(6,15003),
	(3,15004),
	(5,15004),
	(6,15004),
	(6,15001),
    (7,15005);
