drop table if exists test.building;
create table test.building(id INT PRIMARY KEY, name VARCHAR(30), abbrv VARCHAR(5) );

INSERT INTO test.building (id, name, abbrv) VALUES
	(1, "Mabee Business Building", "MBB"),
	(2, "Foster Science Building", "FSB");
