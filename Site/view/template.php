<?php

if(isset($_SESSION["logInfo"]))
{
  $monthFr = array(0, "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
  "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

  $day = date("j", strtotime($_SESSION["logInfo"]["creationDate"]));
  $month = date("n", strtotime($_SESSION["logInfo"]["creationDate"]));
  $year = date("Y", strtotime($_SESSION["logInfo"]["creationDate"]));

  $month = $monthFr[$month];


  $creationDate = "Créé le ".$day." ".$month." ".$year;
}

if(isset($_SESSION["filling"])) { unset($_SESSION["filling"]); }

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta name="viewport" content="user-scalable=yes, initial-scale=0.61">

    <title><?= $title != null ? $title : "SuperBlinder" ?></title>

    <!-- Bootstrap core CSS -->
    <!--<link href="view/content/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">-->
    <link href="view/content/css/core.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <!--<link href="view/content/vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">-->
    <link href="view/content/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="view/content/css/agency.css" rel="stylesheet">
    <link href="view/content/css/custom.css" rel="stylesheet">
    <link href="view/content/css/pages.css" rel="stylesheet">
</head>

<body id="page-top">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav" style="background-color:#AAAAAA;">
    <div class="navbar-content" style="text-align: center;">
        <a href="/"><img height="100%" src="/view/content/img/logo.png"></a>
    </div

    ><?php if(isset($_SESSION["logInfo"])): ?><div id="side-header" class="navbar-content">
        <div>
          <h3><?=$_SESSION["logInfo"]["username"]?></h3>
        </div

        ><div style="font-size: 14px">
          <?=$creationDate?><br>
          TODOTODO de bonnes réponses
        </div

        ><div>
          <button class="btn btn-grey" onclick="window.location='/?page=upload'">Upload</button>
        </div>
      <?php endif ?>
    </div>
  </nav>

  <div class="page-content">
      <?= isset($content) ? $content : "" ?>
  </div>
</body>


<!-- Footer -->
<footer>
  <!--<footer style="background-image: linear-gradient(#888888, #555555)">-->
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <!--
        <ul class="list-inline social-buttons">
            <li class="list-inline-item">
                <a href="#">
                    <i class="fab fa-twitter"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </li>
        </ul>
        -->
      </div>
      <div class="col-md-4">
          <span class="copyright">Copyright &copy; SuperBlinder 2021</span>
      </div>
      <!--
      <div class="col-md-4">
        <ul class="list-inline quicklinks">
          <li class="list-inline-item">
            <a href="#">Privacy Policy</a>
          </li>
          <li class="list-inline-item">
            <a href="#">Terms of Use</a>
          </li>
        </ul>
      </div>
      -->
    </div>
  </div>
</footer>

<!--
<script src="view/content/js/jquery.min.js"></script>
<script src="view/content/js/bootstrap.bundle.min.js"></script>
-->
</html>
