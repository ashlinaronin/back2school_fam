<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Course.php";
    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
            Department::deleteAll();
        }

        function test_getName()
        {
           //Arrange
           $name = "History 0001";
           $code = "HS0001";
           $test_course = new Course($name, $code);

           //Act
           $result = $test_course->getName();

           //Assert
           $this->assertEquals($name, $result);
       }

        function test_save()
        {
            //Arrange
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $name = "History 0001";
            $code = "HS001";
            $test_course = new Course($name, $code, $test_department->getId());
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $name = "History 0001";
            $code = "HS001";
            $test_course = new Course($name, $code, $test_department->getId());
            $test_course->save();

            $name2 = "Dogs 101";
            $code2 = "DW101";
            $test_course2 = new Course($name2, $code2, $test_department->getId());
            $test_course2->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        // find test
        function test_find()
        {
            //Arrange
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $name = "History 0001";
            $code = "HS001";
            $test_course = new Course($name, $code, $test_department->getId());
            $test_course->save();

            $name2 = "Dogs 101";
            $code2 = "DW101";
            $test_course2 = new Course($name2, $code2, $test_department->getId());
            $test_course2->save();

            //Act
            $result = Course::find($test_course->getId());

            //Assert
            $this->assertEquals($test_course, $result);
        }

        //update test
        function test_updateName()
        {
           //Arrange
           $test_department = new Department("Biology", "346 Stupid Avenue");
           $test_department->save();

           $name = "History 0001";
           $code = "HS0001";
           $test_course = new Course($name, $code, $test_department->getId());

           //Act
           $new_name = "Da Constitutia";
           $test_course->updateName($new_name);

           //Assert
           $this->assertEquals($new_name, $test_course->getName());
       }

        //delete test
        function test_delete()
        {
            //Arrange
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $name = "History 0001";
            $code = "HS001";
            $test_course = new Course($name, $code, $test_department->getId());
            $test_course->save();

            $name2 = "Dogs 101";
            $code2 = "DW101";
            $test_course2 = new Course($name2, $code2, $test_department->getId());
            $test_course2->save();

            //Act
            $test_course->delete();

            //Assert
            $result = Course::getAll();
            $this->assertEquals($test_course2, $result[0]);
        }

        //add student and get students tests together
        function test_addStudent()
        {
            //Arrange
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $test_course = new Course("Fundamentals of Human Anatomy", "SEXY101", $test_department->getId());
            $test_course->save();

            $test_course2 = new Course("Organic Chemistry of Cannabinoids", "CHEM420", $test_department->getId());
            $test_course2->save();

            $test_student = new Student("Sarah", "2000-04-01", $test_department->getId());
            $test_student->save();

            //Act
            $test_course->addStudent($test_student);

            //Assert
            $this->assertEquals($test_course->getStudents(), [$test_student]);
        }

        function test_getStudents()
        {
            //Arrange
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $test_course = new Course("Fundamentals of Human Anatomy", "SEXY101", $test_department->getId());
            $test_course->save();

            $test_course2 = new Course("Organic Chemistry of Cannabinoids", "CHEM420", $test_department->getId());
            $test_course2->save();

            $test_student = new Student("Sarah", "2000-04-01", $test_department->getId());
            $test_student->save();

            $test_student2 = new Student("JC", "0000-12-25", $test_department->getId());
            $test_student2->save();

            //Act
            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);
            $test_course2->addStudent($test_student);

            //Assert
            $this->assertEquals($test_course->getStudents(), [$test_student, $test_student2]);
        }
    }
?>
