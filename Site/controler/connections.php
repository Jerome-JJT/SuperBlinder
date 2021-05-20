<?php


function login($postData)
{
  if(isset($postData["email"])
  && isset($postData["password"]))
  {
    try
    {
      require_once("model/userManagement.php");
      $result = loginUser($postData["email"], $postData["password"]);

      if($result["success"])
      {
        $_SESSION["logInfo"] = getUserInfos($postData["email"]);
        header("Location:/");
      }
      else
      {
        displayConnection($error = "Mot de passe faux", $email = $postData["email"]);
      }
    }
    catch(EmailDoesntExistException $e)
    {
      displayConnection($error = "Utilisateur n'existe pas", $email = $postData["email"]);
    }
  }
  else
  {
    displayConnection($error = "Erreur");
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

        if($result)
        {
          header("Location:/");
        }
        else
        {
          displayConnection($error = "Error", $email = $postData["email"], $username = $postData["username"]);
        }
      }
      catch(EmailAlreadyExistException $e)
      {
        displayConnection($error = "Utilisateur existe déjà", $email = $postData["email"], $username = $postData["username"]);
      }
    }
    else
    {
      displayConnection($error = "Mots de passe non identiques", $email = $postData["email"], $username = $postData["username"]);
    }
  }
  else
  {
    displayConnection($error = "Erreur");
  }
}
