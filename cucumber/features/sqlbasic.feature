Feature: Perform basic SQL queries to see if MySQL is working

    Scenario: Grab all rows from 'test.student' table
        Given the query "SELECT * FROM test.student"
        When the driver runs the query
        Then the output should match "1, Roger, A, Gee, 4, 0\n2, Jonathan, A, Schouse, 4, 0\n3, Adam, A, Starbuck, 4, 0\n4, Ethan, A, Waddle, 4, 0\n5, Fresh, M, An, 1, 0\n6, Soph, M, Ore, 2, 0\n"

    Scenario: Grab all 'id' columns from 'test.student' table
        Given the query "SELECT id FROM test.student"
        When the driver runs the query
        Then the output should match "1\n2\n3\n4\n5\n6\n"

    Scenario: Grab all 'fname' columns from 'test.student' table
        Given the query "SELECT fname FROM test.student"
        When the driver runs the query
        Then the output should match "Roger\nJonathan\nAdam\nEthan\nFresh\nSoph\n"

    Scenario: Grab 'lname, fname' columns from 'test.student' table
        Given the query "SELECT lname, fname FROM test.student"
        When the driver runs the query
        Then the output should match "Gee, Roger\nSchouse, Jonathan\nStarbuck, Adam\nWaddle, Ethan\nAn, Fresh\nOre, Soph\n"
