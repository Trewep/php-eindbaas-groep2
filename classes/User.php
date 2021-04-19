<?php

include_once(__DIR__ . "/../interfaces/iUser.php");
include_once(__DIR__ . "/Db.php");

 
class User implements iUser {

    private $avatar;
    private $editEmail;

     /**
     * Get the value of avatar
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }
    

         /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setEmail($editEmail)
    {
        $this->email = $editEmail;

        return $this;
    }
    
    
    public function getAllUsers(){
        $conn = Db::getConnection();

        $result = $conn->query("select * from Users");
        return $result->fetchAll();

        
        
    }

    public static function getUserById(int $id) {
        // only grab the videos for a certain user
        $conn = Db::getConnection();
        $result = $conn->prepare("select * from Users where id = :id");
        $result->bindValue(':id', $id);
        $result->execute();
        return $result->fetch();
    }
    

public function register($username, $email, $firstName, $lastName, $password){
        $option = [
            'cost' => 12,
        ];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT, $option);
    
        $conn = Db::getConnection();
        $stm = $conn->prepare("INSERT INTO Users (firstname, lastname, username, email, password) VALUES (:firstName, :email, :username, :lastName, :password)");
        $stm->bindValue(':username', $username);
        $stm->bindValue(':email', $email);
        $stm->bindValue(':firstName', $firstName);
        $stm->bindValue(':lastName', $lastName);
        $stm->bindValue(':password', $password);
        $stm->execute();
        //var_dump($password);
}

    public function addUser(){}
    public function deleteUser(){}

    
    public function uploadAvatar($id){
        $conn = Db::getConnection();
        $statement = $conn->prepare("update Users set profileImage=:avatar where id = :id ");
        $statement->bindValue(':avatar', $this->avatar);
        $statement->bindValue(':id', $id);
        $statement->execute();


    }

    public function deleteAvatar($id){
        $conn = Db::getConnection();
        $statement = $conn->prepare('UPDATE Users SET profileImage=:defaultAvatar WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->bindValue(':defaultAvatar', 'defaultAvatar');

        $statement->execute();

    }
    
        public function updateEmail($id, $editEmail){
        $conn = Db::getConnection();
        $statement = $conn->prepare("update Users set email=:email where id = :id ");
        $statement->bindValue(':email', $editEmail);
        $statement->bindValue(':id', $id);
        $statement->execute();
        header("Location: ./profileSettings.php");

    }

    public function getUserByUsername($username, $password){
        $conn = Db::getConnection();
        $stm = $conn->prepare("select * from Users where username = :username");
        $stm->bindValue(':username', $username);
        $stm->execute();
        $user = $stm->fetch();
        //var_dump($user);
        if(!$user){
            $stmMail = $conn->prepare("select * from Users where email = :email");
            $stmMail->bindValue(':email', $username);
            $stmMail->execute();
            $user= $stmMail->fetch();
            //var_dump($user);
            
        }if (!$user){
            throw new Exception ("the email or username is wrong");
            return false;
        }
        $hash = $user["password"];
        if (password_verify($password,$hash)){
            $userId = $user['id'];
            $_SESSION["username"] = $username;
            $_SESSION["userId"] = $userId;
            header("Location: ./index.php");
            
            //var_dump($user);
            return true;
        }else{
           throw new Exception ("the password is wrong");
            return false;
        }
        
    }
   
   
}