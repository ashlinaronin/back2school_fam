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
            Department::deleteAll();
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
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $name = "Ashlin Aronin";
            $enrollment_date = "2014-08-09";
            $test_student = new Student($name, $enrollment_date, $test_department->getId());

            //Act
            $test_student->save();

            //Assert
            $result = Student::getAll();
            $this->assertEquals($test_student, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $name = "Ashlin Aronin";
            $enrollment_date = "2015-08-24";
            $test_student = new Student($name, $enrollment_date, $test_department->getId());
            $test_student->save();

            $name2 = "John Nolastname";
            $enrollment_date2 = "2015-07-20";
            $test_student2 = new Student($name, $enrollment_date, $test_department->getId());
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
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $name = "Ashlin Aronin";
            $enrollment_date = "2015-08-24";
            $test_student = new Student($name, $enrollment_date, $test_department->getId());
            $test_student->save();

            $name2 = "John Nolastname";
            $enrollment_date2 = "2015-07-20";
            $test_student2 = new Student($name, $enrollment_date, $test_department->getId());
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
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $name = "Ashlin Aronin";
            $enrollment_date = "2015-08-24";
            $test_student = new Student($name, $enrollment_date, $test_department->getId());
            $test_student->save();

            $name2 = "John Nolastname";
            $enrollment_date2 = "2015-07-20";
            $test_student2 = new Student($name, $enrollment_date, $test_department->getId());
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
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $name = "Ashlin Aronin";
            $enrollment_date = "2015-08-24";
            $test_student = new Student($name, $enrollment_date, $test_department->getId());
            $test_student->save();

            $name2 = "John Nolastname";
            $enrollment_date2 = "2015-07-20";
            $test_student2 = new Student($name, $enrollment_date, $test_department->getId());
            $test_student2->save();

            //Act
            $test_student->delete();

            //Assert
            $result = Student::getAll();
            $this->assertEquals([$test_student2], $result);
        }

        function test_addCourse()
        {
            //Arrange
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $test_student = new Student("Shmuel Irving-Jones", "2015-08-25", $test_department->getId());
            $test_student->save();

            $test_course = new Course("High Times", "CHEM420", $test_department->getId());
            $test_course->save();

            //Act
            $test_student->addCourse($test_course);

            //Assert
            $this->assertEquals($test_student->getCourses(), [$test_course]);
        }

        function test_getCourses()
        {
            //Arrange
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $test_student = new Student("Shmuel Irving-Jones", "2015-08-25", $test_department->getId());
            $test_student->save();

            $test_student2 = new Student("Billy Bartle-Barnaby", "2015-07-09", $test_department->getId());
            $test_student2->save();

            $test_course = new Course("High Times", "CHEM420", $test_department->getId());
            $test_course->save();

            $test_course2 = new Course("Gavanese Jamelan", "MUSC69", $test_department->getId());
            $test_course2->save();

            //Act
            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);
            $test_student2->addCourse($test_course2);

            //Assert
            $this->assertEquals($test_student->getCourses(), [$test_course, $test_course2]);

        }

        function test_updateCompleted()
        {
            //Arrange
            $test_department = new Department("Biology", "346 Stupid Avenue");
            $test_department->save();

            $test_student = new Student("Shmuel Irving-Jones", "2015-08-25", $test_department->getId());
            $test_student->save();

            $test_course = new Course("High Times", "CHEM420", $test_department->getId());
            $test_course->save();

            $test_course2 = new Course("Gavanese Jamelan", "MUSC69", $test_department->getId());
            $test_course2->save();

            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);


            //Act
            $test_student->updateCompleted($test_course->getId());

            //Assert
            $this->assertEquals(true, $test_student->getCompleted($test_course->getId()));
        }
    }



?>
