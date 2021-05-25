<?php

function uploadTrack($postData, $filesData)
{
  if(isset($postData["answer"])
  && isset($postData["difficulty"])
  && isset($postData["type"]))
  {
    $target_dir = "/tracks/";

    if(isset($filesData["video"]["error"]) && $filesData["video"]["error"] === 0)
    {
      $acceptedTypes = array("audio/mpeg");

      if()
      {
        $_SESSION["filling"] = array("uploadError" => "Erreur de format");
        header("Location:/?page=upload"); exit();
      }
      print_r($filesData);
      //getimagesize($filesData["video"]["tmp_name"])
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
