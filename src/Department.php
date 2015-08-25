<?php
    class Department
    {
        private $name;
        private $address;
        private $id;

        function __construct($name, $address, $id = null)
        {
            $this->name = $name;
            $this->address = $address;
            $this->id = $id;
        }


        //getters and setters
        function getName()
        {

        }

        function setName($new_name)
        {

        }

        function getAddress()
        {

        }

        function setAddress($new_address)
        {

        }

        function getId()
        {

        }



        //database jawns
        function save()
        {

        }

        function updateName($new_name)
        {

        }

        function delete()
        {

        }


        //get other classes
        function getStudents()
        {

        }

        function getCourses()
        {
            
        }

        static function getAll()
        {

        }

        static function deleteAll()
        {

        }

        static function find()
        {

        }
    }

?>
