<?php
require_once("includes/header.php");

// $entityId = 1;       // For Manual Video
// $entity = new Entity($con, $entityId);

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo(null);    // passing entity to createPreviewVideo

$containers = new CategoryContainers($con, $userLoggedIn);
echo $containers->showAllCategories();
?>