<?php
/**
 * Author   : Jerome Jaquemet
 * Email : jerome.jaquemet@cpnv.ch
 * Project  : SuperBlinder
 * Last modified  : 2021-06-01
 *
 * Github  : [https://github.com/Jerome-JJT/SuperBlinder]
 *
 */


//Manage files upload to add tracks
function uploadTrack($postData, $filesData)
{
  $uploadDir = "tracks/";

  //Check user form input
  if(isset($postData["answer"])
  && isset($postData["difficulty"])
  && isset($postData["type"]))
  {
    //Manage upload file HTTP errors, if video is provided
    if(isset($filesData["video"]["error"]) && $filesData["video"]["error"] === 0)
    {
      $extension = strtolower(pathinfo($filesData["video"]["name"], PATHINFO_EXTENSION));
      $acceptedVideo = array("mp4", "ogg");
      $sizeVideo = 50000000;

      //Check file extension and size restrictions
      if(!in_array($extension, $acceptedVideo) || $filesData["video"]["type"] > $sizeVideo)
      {
        $_SESSION["filling"] = array("uploadError" => "Erreur de format ou de taille");
        header("Location:/?page=upload"); exit();
      }


      //Search for a filename that doesnt already exists
      do
      {
        $fileName = md5(uniqid(rand(), true)).".".$extension;
        $path = $uploadDir.$fileName;
      } while(file_exists($path));

      move_uploaded_file($filesData['video']['tmp_name'], $path);

      //Insert new track in database
      require_once("model/trackManagement.php");
      insertTrack($postData["answer"], $fileName, $postData["difficulty"], $postData["type"], $_SESSION["logInfo"]["id"]);

      $_SESSION["filling"] = array("success" => "Video ".$postData["answer"]." bien uploadée");
      header("Location:/?page=upload"); exit();
    }
    //Manage upload file HTTP errors, if audio and image are provided - not implemented
    else if(isset($filesData["image"]["error"]) && $filesData["image"]["error"] === 0
         && isset($filesData["audio"]["error"]) && $filesData["audio"]["error"] === 0)
    {

    }
    else
    {
      $_SESSION["filling"] = array("uploadError" => "Erreur de formulaire");
      header("Location:/?page=upload"); exit();
    }
  }
  else
  {
    $_SESSION["filling"] = array("uploadError" => "Erreur de formulaire");
    header("Location:/?page=upload"); exit();
  }
}
