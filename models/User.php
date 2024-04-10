<?php

class User extends Database{
    private $conn;
    private $uri;
    private int $id;
    public string $photo;
    public string $name;
    public string $email;
    public string $password;
    public string $phone;
    public string $sex;
    public string $birth;
    public string $date;
    
    public function __construct(){
        $this->conn = $this->getConnection();
        $this->uri = 'http://localhost/php_projects/back-end';
    }
    public function getUri(){
        return $this->uri;
    }
    public function createUser($photo,$name,$email,$phone,$password,$sex,$birth,$date){

        $stmt = $this->conn->query("INSERT INTO  client (photo,name,email,phone,password,sex,birth,date) VALUES ('$photo','$name','$email','$phone','$password','$sex','$birth','$date')");

        if (isset($_FILES['photo']) && !empty($_FILES['photo'])) {
            
            if (move_uploaded_file($_FILES['photo']['tmp_name'],'./assets/img/users/'.$photo)) {
    
            }
        }

    }
    public function VerifyUser($name){
        $stmt = $this->conn->query("SELECT * FROM client Where name = '$name' ");

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch();
        }else{
            return false;
        }
    }
    public function doSign_up(){

        $info_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/> </svg>';
        $_SESSION['user_msg'] = '';
        
        if (isset($_POST['sign_up'])) {
            $this->photo = empty( $_FILES['photo']['name']) ? 'default.png' :  bin2hex(random_bytes(20)).$_FILES['photo']['name'];
            $this->name = $_POST['name'];
            $this->email = $_POST['email'];
            $this->phone = $_POST['phone'];
            $this->password = $_POST['password'];
            $this->sex = $_POST['sex'];
            $this->birth = $_POST['birth'];
            $this->date = date('d/m/y');
            $redirect = $_POST['redirect'];

            if (empty($this->VerifyUser($this->name))) {

                $this->createUser($this->photo,$this->name,$this->email,$this->phone,$this->password,$this->sex,$this->birth,$this->date);
                header('Location:'.$redirect);

            } else {

                $_SESSION['user_msg'] = "<p class='btn-danger'><span>$info_icon</pan> Esta conta já existe</p>";
            }
            
        }

    }
    public function fetch(){

        if (!empty($_GET['id'])) {
            
            $this->id = $_GET['id'];
            $stmt = $this->conn->prepare("SELECT * FROM client where id = :id");
            $stmt->bindParam(':id',$this->id);
            $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch();
        } else {
            return ['erro'];
        }

        }else if (empty($_GET['id'])){

            $stmt = $this->conn->query("SELECT * FROM client");
            
            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll();
            }else{
                return [];
            }
            
        }
    }
    public function delete(){

        if (!empty($_GET['id'])) {

            $this->id = $_GET['id'];
            $redirect = $_GET['redirect'];
            $stmt = $this->conn->prepare("DELETE FROM client where id = :id");
            $stmt->bindParam(':id',$this->id);
            $stmt->execute();

            header('Location:'.$redirect);
        }
    }

}
