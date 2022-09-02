<?php
class PreviewProvider {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function createCategoryPreviewVideo($categoryId) { // getting a video for preview for categories
        $entitiesArray = EntityProvider::getEntities($this->con, $categoryId, 1); 

        if(sizeof($entitiesArray) == 0) {
            ErrorMessage::show("No TV shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]); // passing the 1st one to play on top
    }

    public function createTVShowPreviewVideo() { // getting a video for preview for tv shows
        $entitiesArray = EntityProvider::getTVShowEntities($this->con, null, 1); 

        if(sizeof($entitiesArray) == 0) {
            ErrorMessage::show("No TV shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]); // passing the 1st one to play on top
    }

    public function createMoviesPreviewVideo() {  // getting a video for preview for movies
        $entitiesArray = EntityProvider::getMoviesEntities($this->con, null, 1);

        if(sizeof($entitiesArray) == 0) {
            ErrorMessage::show("No movies to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    //*********************** Playing the top video******************************/ 
    public function createPreviewVideo($entity) {  // receives the entity
        
        if($entity == null) {   // if it is null
            $entity = $this->getRandomEntity(); // EntityProvider Class'll play
        }

        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();    // filepath
        $thumbnail = $entity->getThumbnail();

        $videoId = VideoProvider::getEntityVideoForUser($this->con, $id, $this->username);
        $video = new Video($this->con, $videoId);
        
        // $inProgress = $video->isInProgress($this->username);
        // $playButtonText = $inProgress ? "Continue watching" : "Play";

        $seasonEpisode = $video->getSeasonAndEpisode();
        $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";

        return "<div class='previewContainer'>

                    <img src='$thumbnail' class='previewImage' hidden>

                    <video autoplay muted class='previewVideo' onended='previewEnded()'>
                        <source src='$preview' type='video/mp4'>
                    </video>

                    <div class='previewOverlay'>
                        
                        <div class='mainDetails'>
                            <h3>$name</h3>
                            $subHeading
                            <div class='buttons'>
                                <button onclick='watchVideo($videoId)'><i class='fas fa-play'></i> Play</button>
                                <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                            </div>

                        </div>

                    </div>
        
                </div>";

    }
 //*************************** Showing every entity into the box ********************************/

    public function createEntityPreviewSquare($entity) {  // small box
        $id = $entity->getId();
        $thumbnail = $entity->getThumbnail();
        $name = $entity->getName();

        return "<a href='entity.php?id=$id'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>
                    </div>
                </a>";
    }

//*************************Collecting random entity***************************** */
    private function getRandomEntity() {

        $entity = EntityProvider::getEntities($this->con, null, 1); // getting an entity limit 1
        return $entity[0];
    }

}
?>