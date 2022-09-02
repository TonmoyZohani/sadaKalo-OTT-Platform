<?php
class EntityProvider {

    public static function getEntities($con, $categoryId, $limit) {

        $sql = "SELECT * FROM entities ";

        if($categoryId != null) {  // if it is not null
            $sql .= "WHERE categoryId=:categoryId "; 
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId != null) {   // if it is not null
            $query->bindValue(":categoryId", $categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();  // declare an empty array
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row);  // create an object
        }

        return $result;
    }

    public static function getTVShowEntities($con, $categoryId, $limit) { 

        $sql = "SELECT DISTINCT(entities.id) FROM `entities`           
                INNER JOIN videos ON entities.id = videos.entityId 
                WHERE videos.isMovie = 0 ";     // isMovie=0 -> No movies  

        if($categoryId != null) {
            $sql .= "AND categoryId=:categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row["id"]); // selecting only id column
        }

        return $result;
    }

    public static function getMoviesEntities($con, $categoryId, $limit) {

        $sql = "SELECT DISTINCT(entities.id) FROM `entities` 
                INNER JOIN videos ON entities.id = videos.entityId 
                WHERE videos.isMovie = 1 ";    // isMovie=1 -> No tvshows 

        if($categoryId != null) {
            $sql .= "AND categoryId=:categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row["id"]);
        }

        return $result;
    }

    public static function getSearchEntities($con, $term) {

        $sql = "SELECT * FROM entities WHERE name LIKE CONCAT('%', :term, '%') LIMIT 30";

        $query = $con->prepare($sql);

        $query->bindValue(":term", $term);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row);
        }

        return $result;
    }

}
?>