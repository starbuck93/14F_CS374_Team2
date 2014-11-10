drop table if exists test.section;
create table test.section(crn INT PRIMARY KEY, professor_id INT, course_id INT, time VARCHAR(5), duration VARCHAR(5), dow VARCHAR(7), room_id INT);

INSERT INTO test.section (crn, professor_id, course_id, time, duration, dow, room_id) VALUES
	(15000, 1, 2, "14:00", "1:00","MWF", 1), -- Reeves, soft eng, 
	(15001, 3, 2, "13:30", "1:30", "TR", 2), -- Crisp, soft eng
	(15002, 2, 3, "15:00", "1:30", "TR", 1), -- Nyandaro, networking
	(15003, 3, 1, "9:00", "1:00", "MWF", 3), -- Crisp, intro
	(15004, 1, 4, "10:00", "1:00", "MWF", 4);