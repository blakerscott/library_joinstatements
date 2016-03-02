
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

        function addAuthor($new_author)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (author_id, book_id) VALUES ({$new_author->getId()}, {$this->getId()})");
        }

        function getAuthor()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT authors.* FROM books
                JOIN books_authors ON (books_authors.book_id = books.id)
                JOIN authors ON (authors.id = books_authors.author_id)
                WHERE books.id = {$this->getId()};");
            $authors = array();
            foreach($returned_authors as $author) {
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($id, $name);
                array_push($authors, $new_author);
            }
            return $authors;
        }


		// function getTasks()
	    //      {
	    //          $returned_tasks = $GLOBALS['DB']->query("SELECT tasks.* FROM categories
	    //              JOIN categories_tasks ON (categories_tasks.category_id = categories.id)
	    //              JOIN tasks ON (tasks.id = categories_tasks.task_id)
	    //              WHERE categories.id = {$this->getId()};");
	    //          $tasks = array();
	    //          foreach($returned_tasks as $task) {
	    //              $description = $task['description'];
	    //              $id = $task['id'];
	    //              $new_task = new Task($description, $id);
	    //              array_push($tasks, $new_task);
	    //          }
	    //          return $tasks;
	    //      }




		// So what's going on inside this JOIN statement? It's happening in a few simple steps: We set our destination: authors.*. This means we want a complete authors table.
// We set our starting point: books. *We collect an id from the books table (chosen at the end of the statement, after WHERE), and join it up with any matching rows in the books_authors table.
// We use the author_id from the matching rows in the books_authors table to select rows from the authors table.
// Finally, our statement returns a complete authors table, as a PDO, composed of only those rows which match our query.
// This single query takes the place of a potentially huge number of other queries, and returns information in an extremely usable PDO format.




	}
 ?>
