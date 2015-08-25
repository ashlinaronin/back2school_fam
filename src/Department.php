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
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getAddress()
        {
            return $this->address;
        }

        function setAddress($new_address)
        {
            $this->address = $new_address;
        }

        function getId()
        {
            return $this->id;
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
