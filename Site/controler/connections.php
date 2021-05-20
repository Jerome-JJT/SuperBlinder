<?php


function login($postData)
{

}


function register($postData)
{
  //print_r($postData);
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
          displayConnection($error = "Erreur", $email = $postData["email"], $username = $postData["username"]);
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
