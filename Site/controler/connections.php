<?php


function login($postData)
{
  if(isset($postData["email"])
  && isset($postData["password"]))
  {
    $result = false;
    try
    {
      require_once("model/userManagement.php");
      $result = loginUser($postData["email"], $postData["password"]);
    }
    catch(EmailDoesntExistException $e)
    {
      $_SESSION["filling"] = array("connectionError" => "Utilisateur n'existe pas", "email" => $postData["email"]);
      header("Location:/"); exit();
    }

    if($result != false)
    {
      $_SESSION["logInfo"] = getUserInfos($postData["email"]);
      header("Location:/"); exit();
    }
    else
    {
      $_SESSION["filling"] = array("connectionError" => "Mot de passe faux", "email" => $postData["email"]);
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
  if(isset($postData["email"])
  && isset($postData["username"])
  && isset($postData["password"])
  && isset($postData["repeatPassword"]))
  {
    if($postData["password"] == $postData["repeatPassword"])
    {
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
  unset($_SESSION["logInfo"]);
  $_SESSION["filling"] = array("success" => "Déconnexion réussie");
  header("Location:/"); exit();
}
