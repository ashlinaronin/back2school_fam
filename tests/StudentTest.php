<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Student.php";
    require_once "src/Course.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown(){
            Student::deleteAll();
            Course::deleteAll();
        }

        function testGetId()
        {
            $course_name = "History 0001";
            $course_number = "HS0001";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);

            $student_name = "Ashlin Aronin";
            $course_id = $test_course->getId();
            $enrollment_date = null;
            $test_student = new Student($student_name, $enrollment_date, $course_id);
            $result = $test_student->getCourseId();

            $this->assertEquals(true, is_numeric($result));

        }

        function testCourseId()
        {

        }

        function testSave()
        {
            $course_name = "History 0001";
            $course_number = "HS0001";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);

            $student_name = "Ashlin Aronin";
            $course_id = $test_course->getId();
            $enrollment_date = null;
            $test_student = new Student($student_name, $course_id);
            $test_student->save();

            $result = Student::getAll();

            $this->assertEquals($test_student, $result[0]);
        }
        //
        // function testGetAll()
        // {
        //     $student_name = "Ashlin Aronin";
        //     $course_id = 1;
        //     $test_student = new Student($student_name, $course_id);
        //     $test_student->save();
        //
        //     $student_name2 = "John Nonlastname";
        //     $test_student2 = new Student($student_name, $course_id);
        //     $test_student2->save();
        //
        //     $result = Student::getAll();
        //
        //     $this->assertEquals([$test_student, $test_student2], $result);
        // }
    }



?>
