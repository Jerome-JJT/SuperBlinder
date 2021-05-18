<?php


function login($postData)
{

}


function register($postData)
{
  if(isset($postData["mail"]) && isset($postData["username"]) && isset($postData["password"]) && isset($postData["repeatPassword"]))
  {
    exit();
  }
  else
  {
    displayConnection($error = "Erreur");
  }
}
