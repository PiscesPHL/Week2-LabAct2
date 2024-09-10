<?php
class Book {
   public $title;
   protected $author;
   private $price;

   function __construct($title, $author, $price) {
       $this->title = $title;
       $this->author = $author;
       $this->price = $price;
   }

   function getDetails() {
       return "Title: $this->title, Author: $this->author, Price: $" . number_format($this->price, 2);
   }

   function setPrice($price) {
       $this->price = $price;
   }

   function __call($method, $args) {
       if ($method == 'updateStock') {
           echo "Stock updated for '$this->title' with arguments: " . implode(', ', $args) . "\n";
       } elseif ($method == 'setPrice') {
           $this->setPrice($args[0]);
       } else {
           throw new Exception("Method '$method' does not exist.");
       }
   }
}

class Library {
   private $books = [];
   public $name;

   function __construct($name) {
       $this->name = $name;
   }

   function addBook(Book $book) {
       $this->books[] = $book;
   }

   function removeBook($title) {
       foreach ($this->books as $i => $book) {
           if ($book->title == $title) {
               unset($this->books[$i]);
               echo "Book '$title' removed from the library.\n";
               return;
           }
       }
       echo "Book '$title' not found in the library.\n";
   }

   function listBooks() {
       echo "Books in the library:\n";
       foreach ($this->books as $book) {
           echo $book->getDetails() . "\n";
       }
   }

   function __destruct() {
       $this->books = [];
       echo "The Library '$this->name' is now closed.\n";
   }
}

$book1 = new Book('The Great Gatsby', 'F. Scott Fitzgerald', 12.99);
$book2 = new Book('1984', 'George Orwell', 8.99);
$library = new Library('City Hall');

$library->addBook($book1);
$library->addBook($book2);

$book1->setPrice(12.99);
$book1->updateStock(50);

$library->listBooks();
$library->removeBook('1984');

echo "Books in the library after removal:\n";
$library->listBooks();

unset($library);
?>