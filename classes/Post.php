<?php

include_once(__DIR__ . "/../interfaces/iPost.php");
include_once(__DIR__ . "/Db.php");



class Post implements iPost
{

    private $followersArray;
    private $userId;
    private $postId;
    private $tag;
    private $location;
    private $image;
    private $filter;
    private $description;

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
    
    /**
     * Get the value of postId
     */ 
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * Set the value of postId
     *
     * @return  self
     */ 
    public function setPostId($postId)
    {
        $this->postId = $postId;

        return $this;
    }

    /**
     * Get the value of tag
     */ 
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set the value of tag
     *
     * @return  self
     */ 
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get the value of location
     */ 
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @return  self
     */ 
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of filter
     */ 
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Set the value of filter
     *
     * @return  self
     */ 
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        if(empty($description)) {
            throw new Exception("The description cannot be empty");
        }
        
        $this->description = $description;

        return $this;
    }

    //haal alle posts op met een bepaalde tag
    public function getPostsByTag() {
        $tag = $this->getTag();
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM Posts WHERE inappropriate != 1 AND (tag1 = :tag1 OR tag2 = :tag2 OR tag3 = :tag3) ORDER BY Posts.id DESC LIMIT 20");
        $statement->bindValue(":tag1", $tag);
        $statement->bindValue(":tag2", $tag);
        $statement->bindValue(":tag3", $tag);
        $statement->execute();
        $posts = $statement->fetchAll();
        //var_dump($posts);
        return $posts;
    }

    //haal alle posts op met een bepaalde locatie
    public function getPostsByLocation($location) {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM Posts WHERE inappropriate != 1 AND location = :location ORDER BY Posts.id DESC LIMIT 20");
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
        $result = $conn->query("SELECT * FROM Posts WHERE inappropriate != 1 ORDER BY id DESC LIMIT 20");
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
        // $ids is safe because the values come from database/ no input from front-end
        // deze manier navragen joris https://stackoverflow.com/questions/920353/can-i-bind-an-array-to-an-in-condition
        $result = $conn->prepare("SELECT * FROM Posts WHERE inappropriate != 1 AND userId IN ($ids) ORDER BY id DESC LIMIT 20 ");
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
        $result = $conn->prepare("SELECT * FROM Posts WHERE inappropriate = 1 ORDER BY id DESC");
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
    public function deletePost()
    {
        
        $id = $this->getPostId();
        $image = $this->getImage();

        $conn = Db::getConnection();
        $statement = $conn->prepare("delete from Posts where image = :image and userId =:id");
        $statement->bindValue(':image', $image);
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        return $result;
    }
    
    //verwijder filter voor een bepaalde image bij een bepaalde user
    public function removeFilter()
    {
        
        $id = $this->getPostId();
        $image = $this->getImage();
        
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE Posts SET filter = '#nofilter' where image = :image AND userId = :userId ");
        $statement->bindValue(':image', $image);
        $statement->bindValue(':userId', $id);
        $statement->execute();
    }
    
    public function addPost(){
        //het pad om de geuploade afbeelding in op te slagen
        $target = "postImages/" . basename($_FILES["uploadFile"]["name"]);
        //het type bestand uitlezen zodat we later non-images kunnen tegenhouden
        $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
        //connectie naar db
        $conn = Db::getConnection();
        //alle data ophalen uit het ingestuurde formulier
        $time = time();
        $userId = $this->getUserId();
        $filter = $this->getFilter();
        $description = $this->getDescription();
        $tag = $this->getTag();
        $location = $this->getLocation();
    
        if(!empty($imageFileType)){
            if($imageFileType === "jpg" || $imageFileType === "jpeg" || $imageFileType === "png") {
                $image = $_FILES["uploadFile"]["name"];
            } else {
                throw new Exception("Please choose a valid png, jpg or jpeg file");
            }
        } else {
            throw new Exception("The image cannot be empty");
        }
        
        //opgehaalde data opslagen in databank
        if(count($tag) === 0) {
            $statement = $conn->prepare("INSERT INTO Posts (userId, image, description, location, filter, time) VALUES (:userId, :image, :description, :location, :filter, :time)");
        }
        elseif(count($tag) === 1) {
            $statement = $conn->prepare("INSERT INTO Posts (userId, tag1, image, description, location, filter, time) VALUES (:userId, :tag1, :image, :description, :location, :filter, :time)");
            $statement->bindValue(":tag1", $tag[0]);
        } elseif(count($tag) === 2) {
            $statement = $conn->prepare("INSERT INTO Posts (userId, tag1, tag2, image, description, location, filter, time) VALUES (:userId, :tag1, :tag2, :image, :description, :location, :filter, :time)");
            $statement->bindValue(":tag1", $tag[0]);
            $statement->bindValue(":tag2", $tag[1]);
        } elseif(count($tag) >= 3) {
            $statement = $conn->prepare("INSERT INTO Posts (userId, tag1, tag2, tag3, image, description, location, filter, time) VALUES (:userId, :tag1, :tag2, :tag3, :image, :description, :location, :filter, :time)");
            $statement->bindValue(":tag1", $tag[0]);
            $statement->bindValue(":tag2", $tag[1]);
            $statement->bindValue(":tag3", $tag[2]);
        }
            $statement->bindValue(":userId", $userId);
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
        
        if ($imageFileType === "jpg" || $imageFileType === "jpeg") {
            $image = imagecreatefromjpeg($target);
        } else {
            $image = imagecreatefrompng($target);
        }
        
        imagejpeg($image, $target, 60);
        
        //de gebruiker terug naar de feed sturen
        header("location: index.php");
    }
    
    public function restoreInappropriate() {
        $id = $this->getPostId();
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE Posts SET inappropriate = :value where id = :id ");
        $statement->bindValue(':value', 0);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
    
    public function deleteInappropriate() {
        $id = $this->getPostId();
        $conn = Db::getConnection();
        $statement = $conn->prepare("DELETE FROM Posts WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
    //haal een bepaalde post op
    public static function getPostByPostId($id) {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM Posts WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        $id = $statement->fetchAll();
        return $id;
    }
    
    public static function getTags() {
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM Tags");
        $statement->execute();
        $tags = $statement->fetchAll();
        return $tags;
    }
    
        public function loadTagsByQuery($query){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM Posts WHERE (tag1 LIKE :query OR tag2 LIKE :query OR tag3 LIKE :query)");
        $statement->bindValue(":query", '%' . $query . '%');
        $statement->execute();
        $foundTags = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $foundTags;
    }
    
    public function getFiltersThisWeek(){
        //https://stackoverflow.com/questions/2507678/get-the-timestamp-of-exactly-one-week-ago-in-php
        $weekAgo = strtotime("-1 week");
        
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT filter FROM Posts WHERE time > :weekAgo");
        $statement->bindValue(':weekAgo', $weekAgo);
        $statement->execute();
        $filters = $statement->fetchAll();
        return $filters;
    }
    
    public function getFilterOfTheWeek(){
        $filtersThisWeek = $this->getFiltersThisWeek();
        
        if(count($filtersThisWeek) == 0){
            return "a mystery 👀";
        }
        
        $filtersCollection = array();
        
        foreach($filtersThisWeek as $filter){
            array_push($filtersCollection, $filter[0]);
        }
        //https://stackoverflow.com/questions/30626785/php-most-frequent-value-in-array
        $values = array_count_values($filtersCollection);
        arsort($values);
        $filterOfTheWeek = array_slice(array_keys($values), 0, 1, true);
        
        return $filterOfTheWeek[0];
    }
}