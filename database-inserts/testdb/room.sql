drop table if exists test.room;
create table test.room(id INT PRIMARY KEY, room_number INT, building_id INT, has_lab BOOLEAN );

INSERT INTO test.room (id, room_number, building_id, has_lab) VALUES
	(1, 314, 1, FALSE),
	(2, 316, 1, FALSE),
	(3, 317, 1, TRUE),
	(4, 312, 1, TRUE),
	(5, 258, 2, TRUE);