<?php 

include_once('./Models/Books.php');

class BooksController {
    public function actionGETBooks() {
        $books = Books::getBooksList();
        echo $books;
        return true;
    }
    public function actionGETBook($parameters) {
        $response = Books::getBookById($parameters);
        echo $response;
        return true;
    }
    public function actionPOSTBooks($book) {
        $response = Books::addBook($book);
        echo $response;
        return true;
    }
    public function actionPATCHBook($parameters) {
        $response = Books::editBook($parameters);
        echo $response;
        return true;
    }
    public function actionDELETEBook($parameters) {
        $response = Books::deleteBook($parameters);
        echo $response;
        return true;
    }
}
?>