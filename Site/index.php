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


session_start();

//Simple login verification
$logged = isset($_SESSION["logInfo"]);
require("controler/views.php");


//Logged user's actions
if(isset($_GET["action"]) && $logged)
{
  switch($_GET["action"])
  {
    case "logout":
      require("controler/connections.php");
      logout();
      break;

    case "generateGame":
      require("controler/gameGeneration.php");
      generateGame($_POST);
      break;

    case "searchGame":
      require("controler/gameGeneration.php");
      searchGame($_POST);
      break;

    case "upload":
      require("controler/uploading.php");
      uploadTrack($_POST, $_FILES);
      break;
  }
}
//Logged user's views
else if(isset($_GET["page"]) && $logged)
{
  switch($_GET["page"])
  {
    case "play":
      require("controler/gamePlay.php");
      processGame($_GET);
      break;

    case "upload":
      displayUploader();
      break;
  }
}
//Default Logged user's view
else if($logged)
{
  displayGenerator();
}

//Disconnected user's allowed actions
else if(isset($_GET["action"]))
{
  switch($_GET["action"])
  {
    case "createAccount":
      require("controler/connections.php");
      register($_POST);
      break;

    case "loginAccount":
      require("controler/connections.php");
      login($_POST);
      break;
  }
}
//Disconnected user cannot have a specific view
else if(isset($_GET["page"]))
{
  header("Location:/"); exit();
}
//Disconnected user's only allowed view
else
{
  displayConnection();
}
