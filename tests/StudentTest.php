<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TaskTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown(){
            Student::deleteAll();
        }

        function testSave()
        {
            $student_name = "Ashlin Aronin";
            $course_id = 1;
            $test_student = new Student($student_name, $course_id);
            $test_student->save();

            $result = Student::getAll();

            $this->assertEquals($test_student, $result[0]);
        }

        function testGetAll()
        {
            $student_name = "Ashlin Aronin";
            $course_id = 1;
            $test_student = new Student($student_name, $course_id);
            $test_student->save();

            $student_name2 = "John Nonlastname";
            $test_student2 = new Student($student_name, $course_id);
            $test_student2->save();

            $result = Student::getAll();

            $this->assertEquals([$test_student, $test_student2], $result);
        }
    }



?>
