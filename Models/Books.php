<?php 

include_once('Connect.php');

class Books {
    public static function getBookById($parameters) {
        $id = $parameters[0];
        $conn = Connect::getConnect();
        $sqlOut = mysqli_query($conn, "SELECT * FROM books WHERE id = $id");
        if (mysqli_num_rows($sqlOut) === 0) {

            http_response_code(404);

            $res = [
                "status" => false,
                "message" => "Book not found",
            ];
            return json_encode($res);
        } else {
            $book = mysqli_fetch_all($sqlOut, MYSQLI_ASSOC);
            return json_encode($book);
        }
    }

    public static function getBooksList() {
        $conn = Connect::getConnect();
        $sqlOut = mysqli_query($conn, "SELECT * FROM books");
        $books = mysqli_fetch_all($sqlOut, MYSQLI_ASSOC);
        return json_encode($books);
    }

    public static function addBook($book) {
        $name = $book['name'];
        $author = $book['author'];
        $year = $book['year'];
        $conn = Connect::getConnect();
        mysqli_query($conn, "INSERT INTO books (`id`, `name`, `author`, `year`) VALUES (NULL, '$name', '$author', $year)");

        http_response_code(201);

        $res = [
            "status" => true,
            "post_id" => mysqli_insert_id($conn),
        ];
        return json_encode($res);
    }

    public static function editBook($parameters) {
        $id = $parameters[0][0];
        $book = $parameters[1];
        $name = $book['name'];
        $author = $book['author'];
        $year = $book['year'];

        $conn = Connect::getConnect();
        mysqli_query($conn, "UPDATE books SET `name` = '$name', `author` = '$author', `year` = $year WHERE `books` . `id` = '$id'");

        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Book is updated",
        ];
        return json_encode($res);
    }

    public static function deleteBook($parameters) {
        $id = $parameters[0];
        $conn = Connect::getConnect();
        mysqli_query($conn, "DELETE FROM books WHERE `books` . `id` = '$id'");

        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Book is deleted",
        ];
        return json_encode($res);
    }
}

?>