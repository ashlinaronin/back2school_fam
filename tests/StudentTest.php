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

        function test_getStudentName()
        {
            //Arrange
            $name = "Ashlin Aronin";
            $enrollment_date = "2014-08-09";
            $test_student = new Student($name, $enrollment_date);

            //Act
            $result = $test_student->getStudentName();

            //Assert
            $this->assertEquals($name, $result);

        }

        function test_save()
        {
            //Arrange
            $name = "Ashlin Aronin";
            $enrollment_date = "2014-08-09";
            $test_student = new Student($name, $enrollment_date);

            //Act
            $test_student->save();

            //Assert
            $result = Student::getAll();
            $this->assertEquals($test_student, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Ashlin Aronin";
            $enrollment_date = "2015-08-24";
            $test_student = new Student($name, $enrollment_date);
            $test_student->save();

            $name2 = "John Nolastname";
            $enrollment_date2 = "2015-07-20";
            $test_student2 = new Student($name, $enrollment_date);
            $test_student2->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        // find test
        function test_find()
        {
            //Arrange
            $name = "Ashlin Aronin";
            $enrollment_date = "2015-08-24";
            $test_student = new Student($name, $enrollment_date);
            $test_student->save();

            $name2 = "John Nolastname";
            $enrollment_date2 = "2015-07-20";
            $test_student2 = new Student($name, $enrollment_date);
            $test_student2->save();

            //Act
            $result = Student::find($test_student2->getId());

            //Assert
            $this->assertEquals($test_student2, $result);
        }

        //update test
        function test_updateName()
        {
            //Arrange
            $name = "Ashlin Aronin";
            $enrollment_date = "2015-08-24";
            $test_student = new Student($name, $enrollment_date);
            $test_student->save();

            $name2 = "John Nolastname";
            $enrollment_date2 = "2015-07-20";
            $test_student2 = new Student($name, $enrollment_date);
            $test_student2->save();

            //Act
            $new_name = "Bashlin Baronan";
            $test_student->updateName($new_name);

            //Assert
            $result = Student::getAll();
            $this->assertEquals($new_name, $result[0]->getStudentName());
        }

        // delete test
        function test_delete()
        {
            //Arrange
            $name = "Ashlin Aronin";
            $enrollment_date = "2015-08-24";
            $test_student = new Student($name, $enrollment_date);
            $test_student->save();

            $name2 = "John Nolastname";
            $enrollment_date2 = "2015-07-20";
            $test_student2 = new Student($name, $enrollment_date);
            $test_student2->save();

            //Act
            $test_student->delete();

            //Assert
            $result = Student::getAll();
            $this->assertEquals([$test_student2], $result);
        }
    }



?>
