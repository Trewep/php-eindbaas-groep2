<?php

/*include_once(__DIR__ . "/../interfaces/iPost.php");*/
include_once(__DIR__ . "/Db.php");



class Post /*implements iPost*/
{

    private $followersArray;
    private $userId;

    /**
     * Get the value of followersArray
     */
    public function getFollowersArray()
    {
        
        return $this->followersArray;
    }

    /**
     * Set the value of followersArray
     *
     * @return  self
     */
    public function setFollowersArray($followersArray)
    {
        $this->followersArray = $followersArray;

        return $this;
    }

    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    //haal alle posts op met een bepaalde tag
    public function getPostsByTag($tag) {
        $conn = Db::getConnection();
        //V1
        //$statement = $conn->prepare("SELECT * FROM Posts,Tags WHERE Tags.id = Posts.tagId AND Tags.name = :tag ORDER BY id DESC LIMIT 20");
        //V2
        //$statement = $conn->prepare("SELECT * FROM Posts,Tags WHERE Posts.tagId = Tags.id AND name=:tag ORDER BY Posts.id DESC LIMIT 20");
        $statement = $conn->prepare("SELECT * FROM Posts WHERE tag = :tag ORDER BY Posts.id DESC LIMIT 20");
        $statement->bindValue(":tag", $tag);
        $statement->execute();
        $posts = $statement->fetchAll();
        //var_dump($posts);
        return $posts;
    }

    //haal alle posts op met een bepaalde locatie
    public function getPostsByLocation($location) {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM Posts WHERE location = :location ORDER BY Posts.id DESC LIMIT 20");
        $statement->bindValue(":location", $location);
        $statement->execute();
        $posts = $statement->fetchAll();
        //var_dump($posts);
        return $posts;
    }
    //haal de 20 laatste post op die geuploaded zijn
    public function get20LastPosts()
    {
        $conn = Db::getConnection();
        $result = $conn->query("SELECT * FROM Posts ORDER BY id DESC LIMIT 20");
        return $result->fetchAll();
    }

    //use array with id's from people user is following to get 20 last followers post
    public function get20lastFollowersPosts()
    {

        $followersArray = $this->getFollowersArray();

        //make a single line from array
        $ids = join(', ', $followersArray);
        $conn = Db::getConnection();
        // get all posts from followers in $ids array in descending order and limited by 20 most recent
        // $ids is safe becquse the values come from database/ no input from front-end
        // deze manier navragen joris https://stackoverflow.com/questions/920353/can-i-bind-an-array-to-an-in-condition
        $result = $conn->prepare("SELECT * FROM Posts WHERE userId IN ($ids) ORDER BY id DESC LIMIT 20 ");
        //$result->bindValue(':ids',  $ids );
        $result->execute();
        // save posts 
        $followersPosts = $result->fetchAll();
        return $followersPosts;
    }
    
    public static function isLiked($postId, $userId){
    $conn = Db::getConnection();
    $statement = $conn->prepare("select * from Likes where postId = :postId AND userId =:userId");
    $statement->bindValue(':postId',  $postId);
    $statement->bindValue(':userId',  $userId);
    $statement->execute();
    $test = $statement->fetchAll();
    //var_dump($test);
    return $test;
    }
    
    public function getInappropriatePosts(){
        $conn = Db::getConnection();
        // get all inappropriatePosts
        $result = $conn->prepare("SELECT * FROM Posts WHERE inappropriate = 1");
        $result->execute();
        // save posts 
        $inappropriatePosts = $result->fetchAll();
        return $inappropriatePosts;
    }
    
    
    //haal de gegevens op van posts waar de userId gelijk is aan de meegegevn id
    public function getPostByuserId()
    {

        $userId = $this->getUserId();

        $conn = Db::getConnection();
        $result = $conn->prepare("select * from Posts where userId = :id");
        $result->bindValue(':id', $userId);
        $result->execute();
        return $result->fetchAll();
        var_dump($result);
    }
    
    //verwijder een post uit de db
    public function deletePost($image,$id)
    {

        $conn = Db::getConnection();
        $statement = $conn->prepare("delete from Posts where image = :image and userId =:id");
        $statement->bindValue(':image', $image);
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        return $result;
    }
    
        //verwijder filter voor een bepaalde image bij een bepaalde user
    public function removeFilter($image, $id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE Posts SET filter = '#nofilter' where image = :image AND userId = :userId ");
        $statement->bindValue(':image', $image);
        $statement->bindValue(':userId', $id);
        $statement->execute();
    }
    
    /*public function compressImage($source, $destination, $quality){
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
        }
        
        imagejpeg($image, $destination, $quality);
    }*/
    
    public function addPost($userId, $filter, $description, $tag, $location){
        //het pad om de geuploade afbeelding in op te slagen
        $target = "postImages/" . basename($_FILES["uploadFile"]["name"]);
        //het type bestand uitlezen zodat we later non-images kunnen tegenhouden
        $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
        //connectie naar db
        $conn = Db::getConnection();
        //alle data ophalen uit het ingestuurde formulier
    
        if(!empty($imageFileType)){
            if($imageFileType === "jpg" || $imageFileType === "png") {
                $image = $_FILES["uploadFile"]["name"];
            } else {
                throw new Exception("Please choose a valid png or jpg file");
            }
        } else {
            throw new Exception("The image cannot be empty");
        }
        
        if(empty($description)) {
            throw new Exception("The description cannot be empty");
        }
    
        //$location = $_POST['location'];
        //$tag = strtolower($_POST['tag']);
        $time = time();
        
        /*$info = getimagesize($image);

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($image);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($image);
        }
        
        imagejpeg($image, $target, 10);*/
        
        //compressImage($image, $target, 10);
    
        //opgehaalde data opslagen in databank
        $statement = $conn->prepare("INSERT INTO Posts (userId, tag, image, description, location, filter, time) VALUES (:userId, :tag, :image, :description, :location, :filter, :time)");
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":tag", $tag);
        $statement->bindValue(":image", $image);
        $statement->bindValue(":description", $description);
        $statement->bindValue(":location", $location);
        $statement->bindValue(":filter", $filter);
        $statement->bindValue(":time", $time);
        $statement->execute();
        
        //geuploade afbeelding in de images folder zetten
        if(move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target)) {
            $message = "Image uploaded succesfully";
        } else {
            $message = "There was a problem posting the image";
        }
        
        //de gebruiker terug naar de feed sturen
        header("location: index.php");
    }
}