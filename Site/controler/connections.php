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


function login($postData)
{
  //Verify user form inputs
  if(isset($postData["email"])
  && isset($postData["password"]))
  {
    $result = false;

    //Login request
    try
    {
      require_once("model/userManagement.php");
      $result = loginUser($postData["email"], $postData["password"]);
    }
    catch(EmailDoesntExistException $e)
    {
      //$_SESSION["filling"] = array("connectionError" => "Utilisateur n'existe pas", "email" => $postData["email"]);
      $_SESSION["filling"] = array("connectionError" => "Erreur", "email" => $postData["email"]);
      header("Location:/"); exit();
    }

    //If login is successful
    if($result != false)
    {
      $_SESSION["logInfo"] = getUserInfos($postData["email"]);
      header("Location:/"); exit();
    }
    else
    {
      //$_SESSION["filling"] = array("connectionError" => "Mot de passe faux", "email" => $postData["email"]);
      $_SESSION["filling"] = array("connectionError" => "Erreur", "email" => $postData["email"]);
      header("Location:/"); exit();
    }
  }
  else
  {
    $_SESSION["filling"] = array("connectionError" => "Erreur");
    header("Location:/"); exit();
  }
}



function register($postData)
{
  //Verify user form input
  if(isset($postData["email"])
  && isset($postData["username"])
  && isset($postData["password"])
  && isset($postData["repeatPassword"]))
  {
    if($postData["password"] == $postData["repeatPassword"])
    {
      //Register request
      try
      {
        require_once("model/userManagement.php");
        $result = createUser($postData["email"], $postData["username"], $postData["password"]);
      }
      catch(EmailAlreadyExistException $e)
      {
        $_SESSION["filling"] = array("connectionError" => "Utilisateur existe déjà",
        "email" => $postData["email"],
        "username" => $postData["username"]);

        header("Location:/"); exit();
      }

      //If register is successful
      if($result != false)
      {
        $_SESSION["filling"] = array("success" => "Compte créé", "email" => $postData["email"]);
        header("Location:/"); exit();
      }
      else
      {
        $_SESSION["filling"] = array("connectionError" => "Compte existe déjà", "email" => $postData["email"], "username" => $postData["username"]);
        header("Location:/"); exit();
      }
    }
    else
    {
      $_SESSION["filling"] = array("connectionError" => "Mots de passe non identiques", "email" => $postData["email"], "username" => $postData["username"]);
      header("Location:/"); exit();
    }
  }
  else
  {
    $_SESSION["filling"] = array("connectionError" => "Erreur");
    header("Location:/"); exit();
  }
}


function logout()
{
  //Clear login session
  unset($_SESSION["logInfo"]);
  
  $_SESSION["filling"] = array("success" => "Déconnexion réussie");
  header("Location:/"); exit();
}
