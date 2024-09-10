<?php

class Book {
    //book class properties:
    public $title;      //for book's title
    protected $author;  //for book's author 
    private $price;     //for book's price

    //to construct (set up) a new book and its properties
    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->setPrice($price);
    }

    //book class methods:
    //to get a formatted string of the book's details
    public function getDetails() {
        return "Title: ". $this->title .", Author: " . $this->author . ", Price: $" . $this->price;
    }

    //to set the book's price and ensures that it is non-negative
    public function setPrice($price) {
        if ($price >= 0) {
            $this->price = $price;
        } else {
            echo "Price cannot be negative. <br>";
        }
    }

    //Magic method __call which handles the methods that don't exist
    public function __call($name, $arguments) {
        if ($name === 'updateStock') {
            return "Stock updated for '" . $this->title . "' with arguments: " . $arguments[0] . "<br>";
        }
        return "Method '" . $name . "' does not exist. <br>";
    }
}

//library class
class Library {
    //library class properties:
    private $books = [];  //the array whichs stores the collection of books
    public $name;         //library's name

    //initializes the library with a name
    public function __construct($name) {
        $this->name = $name;
    }

    //library class methods:
    //adds new book to the library's collection
    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    //to remove a book by its title
    public function removeBook($title) {
        foreach ($this->books as $key => $book) {
            if ($book->title === $title) {
                unset($this->books[$key]);
                return "Book '" . $title . "' removed from the library. <br>";
            }
        }
        return "Book '" . $title . "' not found. <br>";
    }

    //this lists all books currently in the library
    public function listBooks() {
        if (empty($this->books)) {
            return "No books available in the library. <br>";
        }
        $output = "";
        foreach ($this->books as $book) {
            $output .= $book->getDetails() . "<br>";
        }
        return $output;
    }

    //Cleanup when the library object is no longer needed
    public function __destruct() {
        echo "The library '" . $this->name . "' is now closed. <br>";
    }
}

//Implementation tasks

//Creates instances of books and its details
$book1 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 12.99);
$book2 = new Book("1984", "George Orwell", 8.99);

//Creates a library instance
$library = new Library("City Library");

//Add books to the library's collection
$library->addBook($book1);
$library->addBook($book2);

//this updates the stock for the first book and display the message
$output = $book1->updateStock(50);

//this lists all the books in the library
$output .= "Books in the library:<br>" . $library->listBooks();

//used to remove specific book from the library
$output .= $library->removeBook("1984");

//this lists all the books in the library after the removal process
$output .= "Books in the library after removal:<br>" . $library->listBooks();

//shows the final output
echo $output;

//to unset (clean) the library objects at the end to trigger the destructor
unset($library);



//o	Include a brief explanation of how you approached the problem, focusing on how each concept was used in your solution.
//EXPLANATION:
//The objectives is ato create a system where you can manage books and a library, 
//and that it had to make sure the data (like the price of a book) is kept safe. 
//Additionally we can add, remove, and list books easily. 
//I followed the sequence intructions one by one in order for me not to be confused and have messy codes.

//Key concepts like access modifiers were used to control visibility of properties, 
//ensuring that only certain parts of the code can change or access them. 
//Constructors were used to automatically set up objects when they’re created, 
//while setters and getters managed the updating and retrieval of data safely. 
//The __call() magic method is used to handle calls to non-existent methods, simulating method overloading. 
//Lastly, the destructor is implemented to clean up resources when the library is no longer needed.

//A summery of the program flow is:
//1. Book objects are created.
//2. Library object is created.
//3. Books are added to the library.
//4. Stock is updated using the magic method.
//5. Books are listed.
//6. A book is removed.
//7. Books are listed again.
//8. Library is destroyed, triggering the destructor.
?>
