drop table if exists test.office_hours;
create table test.office_hours(id INT PRIMARY KEY, professor_id INT, time VARCHAR(5), duration VARCHAR(5), dow VARCHAR(7));

-- i removed room because office hours do not compete with classes for classrooms
-- I also removed intersection for office hour and professor, because it is not needed for a one to many
-- all changes are reflected in the schema

INSERT INTO test.office_hours (id, professor_id, time, duration, dow) VALUES
	(1, 1, "15:00", "2:00","MWF"),
	(2, 2, "14:00", "1:00","W"),
	(3, 2, "13:00", "2:00","TR"),
	(4, 3, "13:00", "1:00","MWF"),
	(5, 3, "9:30", "1:00","TR"); 