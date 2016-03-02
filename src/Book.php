
<?php
	 class Book
	{
		private $id;
		private $title;

		function __construct($id = null, $title)
        {
			$this->id = $id;
            $this->title = $title;

        }
		function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }
        function getTitle()
        {
            return $this->title;
        }
		function getId()
        {
            return $this->id;
        }

		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO books (title)
            VALUES ('{$this->getTitle()}');
            ");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}

		static function getAll()
		{//gets every single book
			$returned_books = array();
			$all_books = $GLOBALS['DB']->query("SELECT * FROM books;");
			foreach ($all_books as $book) {
				$id = $book['id'];
				$title = $book['title'];
				$new_book = new Book($id, $title);
                array_push($returned_books, $new_book);
			}//make sure you are pushing the object you created,'new_book' and not the object you are pulling from your database, 'book'
            return $returned_books;
		}

		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM books;");
		}
		function updateTitle($new_title)
		{
			$GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
			$this->setTitle($new_title);
		}
		static function find($search_id)
		{
			$found_book = null;
			$all_books = Book::getAll();
			foreach($all_books as $book) {
				if ($search_id == $book->getId()){
					$found_book = $book;
				}
			}	return $found_book;
		}

		function delete()
		{//delete one course
			//will update later to delete all students in that course
			$GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
			$GLOBALS['DB']->exec("DELETE FROM books WHERE book_id = {$this->getId()};");
		}


	}
 ?>
