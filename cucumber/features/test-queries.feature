Feature: Perform basic test queries using the test schema

    Scenario: Display all students taking section with CRN=15002
        Given the query "SELECT lname, fname FROM test.student INNER JOIN test.student_section ON test.student.id = test.student_section.student_id WHERE test.student_section.section_id = 15002"
        When the driver runs the query
        Then the output should match "Schouse, Jonathan\nAn, Fresh\nOre, Soph\n"
