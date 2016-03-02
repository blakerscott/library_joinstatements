<?php

    class Author
    {
        private $id;
        private $name;

        function __construct($id = null, $name)
        {
            $this->id = $id;
            $this->name = $name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }
        
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors (name)
            VALUES ('{$this->getName()}');
            ");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

    }



 ?>
