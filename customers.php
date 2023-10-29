<?php
class Customers
{
    private $server_name = "localhost";
    private $user_name = "root";
    private $password = "";
    private $database = "oop_crud";
    public $con;
    public function __construct()
    {
        $this->con = new mysqli($this->server_name, $this->user_name, $this->password, $this->database);
        if (mysqli_connect_error()) {
            trigger_error("Failed to Connect Mysql:" . mysqli_connect_error());
        } else {
            return $this->con;
        }
    }

    public function insertData($post)
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "INSERT INTO customers (name, email, username, password) VALUES('$name', '$email', '$username', '$password')";

        $query = $this->con->query($sql);

        if ($query == true) {
            header("Location:index.php?msg1 = insert");
        } else {
            echo "Registration Failed try again";
        }
    }

    public function displayData()
    {
        $sql = "SELECT * from customers";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            echo "No data records";
        }
    }

    // Fetch single data for edit from customer table
    public function displayRecordById($id)
    {
        $query = "SELECT * FROM customers WHERE id = '$id'";
        $result = $this->con->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            echo "Record not found";
        }
    }

    // Update customer data into customer table
    public function updateRecord($postData)
    {
        $name = $this->con->real_escape_string($_POST['uname']);
        $email = $this->con->real_escape_string($_POST['uemail']);
        $username = $this->con->real_escape_string($_POST['upname']);
        $id = $this->con->real_escape_string($_POST['id']);
        if (!empty($id) && !empty($postData)) {
            $query = "UPDATE customers SET name = '$name', email = '$email', username = '$username' WHERE id = '$id'";
            $sql = $this->con->query($query);
            if ($sql == true) {
                header("Location:index.php?msg2=update");
            } else {
                echo "Registration updated failed try again!";
            }
        }
    }

    // Delete customer data from customer table
    public function deleteRecord($id)
    {
        $query = "DELETE FROM customers WHERE id = '$id'";
        $sql = $this->con->query($query);
        if ($sql == true) {
            header("Location:index.php?msg3=delete");
        } else {
            echo "Record does not delete try again";
        }
    }
}
