drop table if exists test.section;
create table test.section(crn INT PRIMARY KEY, professor_id INT, course_id INT, time VARCHAR(5), duration INT, dow VARCHAR(7), room_id INT);

INSERT INTO test.section (crn, professor_id, course_id, time, duration, dow, room_id) VALUES
	(15000, 1, 2, "14:00", 50,"MWF", 1), -- Reeves, soft eng, 
	(15001, 3, 2, "13:30", 80, "TR", 2), -- Crisp, soft eng
	(15002, 2, 3, "15:00", 80, "TR", 1), -- Nyandaro, networking
	(15003, 4, 1, "9:00",  50, "MWF", 3), -- Homer, intro to computer science
	(15004, 1, 4, "10:00", 50, "MWF", 4), -- Reeves, mobile computing
    (15005, 3, 5, "10:00", 50, "MWF", 3); -- Crisp, intro to IS
