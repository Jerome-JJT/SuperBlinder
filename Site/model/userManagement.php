<?php

class EmailAlreadyExistException extends Exception { }

function createUser($userEmail, $userName, $userPassword)
{
  $query = "SELECT COUNT(id) AS count FROM USERS WHERE email = :email";
  $data = array(":email" => $userEmail);

  require_once("model/dbConnector.php");
  $emailExist = executeQuerySelect($query, $data)[0];

  if($emailExist["count"] > 0)
  {
    throw new EmailAlreadyExistException();
  }

  $hashedPassword = password_hash($userPassword, PASSWORD_BCRYPT);
  $creationDate = date("Y-m-d");

  $query = "INSERT INTO USERS (email, username, password, creationDate)
  VALUES (:email, :username, :password, :creationDate)";

  $data = array(":email" => $userEmail, ":username" => $userName,
  ":password" => $hashedPassword, ":creationDate" => $creationDate);

  $success = executeQueryAction($query, $data);


  return $success;
}
