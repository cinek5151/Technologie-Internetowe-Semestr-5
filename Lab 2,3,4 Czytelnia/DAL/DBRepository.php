<?php

class DBRepository
{

    public $address = "31.172.70.199";
    public $port = 3306;
    public $user = "root";
    public $password = "root";
    public $db = "library";
    
    
    
    function __construct()
    {
    }

    public function getDBConnection()
    {
        $mysqli = new mysqli($this->address, $this->user, $this->password, $this->db);

        if ($mysqli->connect_errno) {
            var_dump($mysqli->connect_error);
            exit();
        }

        return $mysqli;
    }

    public function addUser(User $user)
    {
        $conn = $this->getDBConnection();

        $sql = "INSERT INTO users (email, name, password) VALUES ('$user->email', '$user->name', '$user->password')";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            var_dump($conn->error);
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        $conn = $this->getDBConnection();

        $sql = "SELECT * FROM users WHERE email='$email'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function getUserIdByEmail($email)
    {
        $user = $this->getUserByEmail($email);
        if ($user == null) {
            return -1;
        }

        return $user['id'];
    }

    public function userExists($email)
    {
        if ($this->getUserByEmail($email) != null) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllBooks()
    {
        $conn = $this->getDBConnection();
        $sql = "SELECT * FROM books";

        return $conn->query($sql);
    }

    public function getBookById($id)
    {
        $conn = $this->getDBConnection();
        $sql = "SELECT * FROM books WHERE id = '$id'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function borrowBook($userId, $bookId, $startDate, $endsDate)
    {
        $conn = $this->getDBConnection();

        $sql = "INSERT INTO borrows (user_id, book_id, ends_date, start_date) VALUES ('$userId', '$bookId', '$endsDate', '$startDate')";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            var_dump($conn->error);
            return false;
        }
    }

    public function getBorrow($userId, $bookId)
    {
        $conn = $this->getDBConnection();
        $sql = "SELECT * FROM borrows WHERE user_id = '$userId' AND book_id = '$bookId'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function isAlreadyBorrowed($userId, $bookId)
    {
        $conn = $this->getDBConnection();
        $sql = "SELECT * FROM borrows WHERE user_id = '$userId' AND book_id = '$bookId'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $borrow = $result->fetch_assoc();

            if ($this->getBorrowExpirationDays($borrow['ends_date']) < 0) {
                $this->removeBorrow($borrow['id']);
                return false;
            }

            return true;

        } else {
            return false;
        }
    }


    public function getBorrowExpirationDays($endsDate)
    {
        $startDate = strtotime(date("Y-m-d"));
        $endsDate = strtotime($endsDate);
        return round(($endsDate - $startDate) / (60 * 60 * 24));
    }

    public function removeBorrow($id)
    {
        $conn = $this->getDBConnection();
        $sql = "DELETE FROM borrows WHERE id = '$id'";
        $conn->query($sql);
    }

    public function getBorrowedBooks($userId)
    {
        $conn = $this->getDBConnection();
        $sql = "SELECT * FROM books as b, borrows as br WHERE br.user_id = '$userId' AND b.id = br.book_id";
        return $conn->query($sql);
    }

}