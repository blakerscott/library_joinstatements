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

        static function getAll()
		{//gets every single book
			$returned_authors = array();
			$all_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
			foreach ($all_authors as $author) {
				$id = $author['id'];
				$name = $author['name'];
				$new_author = new Author($id, $name);
                array_push($returned_authors, $new_author);
			}//make sure you are pushing the object you created,'new_book' and not the object you are pulling from your database, 'book'
            return $returned_authors;
		}

        static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM authors;");
		}

        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        static function find($search_id)
        {
            $found_author = null;
            $all_authors = Author::getAll();
            foreach($all_authors as $author) {
                if ($search_id == $author->getId()){
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        function delete()
		{//delete one course
			//will update later to delete all students in that course
			$GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
			$GLOBALS['DB']->exec("DELETE FROM authors WHERE author_id = {$this->getId()};");
		}

}



 ?>
