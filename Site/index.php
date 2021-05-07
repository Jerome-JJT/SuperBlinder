<?php

session_start();

//print_r($_SESSION);




if(isset($_GET["action"]) && $logged)
{
  switch($_GET["action"])
  {
    case "generate":
      //generateBlindTest();
      break;
  }
}
else if(isset($_GET["page"]) && $logged)
{
  switch($_GET["page"])
  {
    case "upload":
      //displayUpload();
      break;

    case "play":
      //displayUpload();
      break;

    default:
      //displayGenerator();

  }
}


else if(isset($_GET["action"]))
{
  switch($_GET["action"])
  {
    case "createAccount":
      //createAccount($_POST);
      break;

    case "loginAccount":
      //loginAccount($_POST);
      break;
  }
}
else
{
  require("view/template.php");
  //displayConnection();
}
