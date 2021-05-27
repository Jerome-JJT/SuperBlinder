<?php

function uploadTrack($postData, $filesData)
{
  $uploadDir = "tracks/";


  if(isset($postData["answer"])
  && isset($postData["difficulty"])
  && isset($postData["type"]))
  {
    $target_dir = "/tracks/";

    if(isset($filesData["video"]["error"]) && $filesData["video"]["error"] === 0)
    {
      $extension = strtolower(pathinfo($filesData["video"]["name"], PATHINFO_EXTENSION));
      $acceptedVideo = array("mp4", "ogg");
      $sizeVideo = 50000000;

      if(!in_array($extension, $acceptedVideo) || $filesData["video"]["type"] > $sizeVideo)
      {
        $_SESSION["filling"] = array("uploadError" => "Erreur de format ou de taille");
        header("Location:/?page=upload"); exit();
      }


      do
      {
        $fileName = md5(uniqid(rand(), true)).".".$extension;
        $path = $uploadDir.$fileName;
      } while(file_exists($path));

      move_uploaded_file($filesData['video']['tmp_name'], $path);

      require_once("model/trackManagement.php");
      insertTrack($postData["answer"], $fileName, $postData["difficulty"], $postData["type"], $_SESSION["logInfo"]["id"]);

      $_SESSION["filling"] = array("success" => "Video ".$postData["answer"]." bien uploadée");
      header("Location:/?page=upload"); exit();
    }
    else if(isset($filesData["image"]["error"]) && $filesData["image"]["error"] === 0
         && isset($filesData["audio"]["error"]) && $filesData["audio"]["error"] === 0)
    {

    }
    else
    {
      $_SESSION["filling"] = array("uploadError" => "Erreur de formulaire");
      header("Location:/?page=upload"); exit();
    }
    /*$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }*/
  }
  else
  {
    $_SESSION["filling"] = array("uploadError" => "Erreur de formulaire");
    header("Location:/?page=upload"); exit();
  }

}
