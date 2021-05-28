<?php

class EmailAlreadyExistException extends Exception { }
class EmailDoesntExistException extends Exception { }


function getUserInfos($userEmail)
{
  $query = "SELECT users.ID AS userId, users.email, users.username, users.creationDate, COALESCE(ROUND(AVG(scores.score),0),0) AS score
  FROM users LEFT JOIN scores ON users.ID = scores.userId
  WHERE email = :email";

  $data = array(":email" => $userEmail);

  require_once("model/dbConnector.php");
  $result = executeQuerySelect($query, $data);

  if(count($result) === 0)
  {
    throw new EmailDoesntExistException();
  }
  $result = $result[0];

  return array(
    "id" => $result["userId"],
    "email" => $result["email"],
    "username" => $result["username"],
    "creationDate" => $result["creationDate"],
    "score" => $result["score"]
  );
}


function loginUser($userEmail, $userPassword)
{
  $query = "SELECT id, email, username, password, creationDate FROM users WHERE email = :email";
  $data = array(":email" => $userEmail);

  require_once("model/dbConnector.php");
  $result = executeQuerySelect($query, $data);

  if(count($result) === 0)
  {
    throw new EmailDoesntExistException();
  }
  $result = $result[0];

  $success = password_verify($userPassword, $result["password"]);

  return $success;
}

function addScore($gameId, $userId, $score)
{
  $query = "SELECT COUNT(ID) AS count FROM scores WHERE gameId = :gameId AND userId = :userId";
  $data = array(":gameId" => $gameId, ":userId" => $userId);

  require_once("model/dbConnector.php");
  $scoreExist = executeQuerySelect($query, $data)[0];

  if($scoreExist["count"] > 0)
  {
    return false;
  }

  $query = "INSERT INTO scores (gameId, userId, score)
  VALUES (:gameId, :userId, :score)";

  $data = array(":gameId" => $gameId, ":userId" => $userId, ":score" => $score);

  $success = executeQueryAction($query, $data);

  return $success;
}


function createUser($userEmail, $userName, $userPassword)
{
  $query = "SELECT COUNT(id) AS count FROM users WHERE email = :email";
  $data = array(":email" => $userEmail);

  require_once("model/dbConnector.php");
  $emailExist = executeQuerySelect($query, $data);

  if($emailExist["count"] > 0)
  {
    throw new EmailAlreadyExistException();
  }


  $hashedPassword = password_hash($userPassword, PASSWORD_BCRYPT);
  $creationDate = date("Y-m-d");

  $query = "INSERT INTO users (email, username, password, creationDate)
  VALUES (:email, :username, :password, :creationDate)";

  $data = array(":email" => $userEmail, ":username" => $userName,
  ":password" => $hashedPassword, ":creationDate" => $creationDate);

  $success = executeQueryAction($query, $data);

  return $success;
}
