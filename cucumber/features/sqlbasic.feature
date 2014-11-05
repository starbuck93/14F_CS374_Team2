Feature: Perform basic SQL queries to see if MySQL is working

    Scenario: Grab all rows from 'test.student' table
        Given the query "SELECT * FROM test.student"
        When the driver runs the query
        Then the output should match "1, Roger, Gee\n2, Jonathan, Shouse\n3, Adam, Starbuck\n"

    Scenario: Grab all 'id' columns from 'test.student' table
        Given the query "SELECT id FROM test.student"
        When the driver runs the query
        Then the output should match "1\n2\n3\n"

    Scenario: Grab all 'fname' columns from 'test.student' table
        Given the query "SELECT fname FROM test.student"
        When the driver runs the query
        Then the output should match "Roger\nJonathan\nAdam\n"

    Scenario: Grab 'lname, fname' columns from 'test.student' table
        Given the query "SELECT lname, fname FROM test.student"
        When the driver runs the query
        Then the output should match "Gee, Roger\nShouse, Jonathan\nStarbuck, Adam\n"
