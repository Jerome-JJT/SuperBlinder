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


ob_start();

$title = "SuperBlinder - Connexion";

//Prefilled texts
$success = isset($_SESSION["filling"]["success"]) ? $_SESSION["filling"]["success"] : "";
$error = isset($_SESSION["filling"]["connectionError"]) ? $_SESSION["filling"]["connectionError"] : "";
$email = isset($_SESSION["filling"]["email"]) ? $_SESSION["filling"]["email"] : "";
$username = isset($_SESSION["filling"]["username"]) ? $_SESSION["filling"]["username"] : "";

?>


<div id="login-page">
  <p style="text-align:center">
    Merci de vous connecter pour accéder au site
  </p>

  <p style="text-align:center; color: red">
    <?=$error?>
  </p>
  <p style="text-align:center; color: green">
    <?=$success?>
  </p>


  <div class="login-block">
    <h3>Connexion</h3>

    <form method="POST" action="?action=loginAccount">
      <table class="login-table">
        <tr>
          <td>Adresse mail</td>

          <td><input type="email" name="email" value="<?=$email?>" required autocomplete="off"></td>
        </tr>
        <tr>
          <td>Mot de passe</td>

          <td><input type="password" name="password" required></td>
        </tr>

        <tr>
          <td>
            <button type="button" style="font-size: 14px" onclick="window.location = 'mailto:jerome.jaquemet@cpnv.ch'">Mot de passe oublié</button>
          </td>
          <td>
            <button type="submit">Login</button>
          </td>
        </tr>
      </table>
    </form>
  </div

  ><div class="login-bar">
  </div

  ><div class="login-block">
    <h3>Nouveau compte</h3>

    <form method="POST" action="?action=createAccount">
      <table class="login-table">
        <tr>
          <td>Adresse mail</td>

          <td><input type="email" name="email" value="<?=$email?>" required autocomplete="off"></td>
        </tr>
        <tr>
          <td>Username</td>

          <td><input type="text" name="username" value="<?=$username?>" required autocomplete="off"></td>
        </tr>
        <tr>
          <td>Mot de passe</td>

          <td><input type="password" name="password" required></td>
        </tr>
        <tr>
          <td>Répéter le mot de passe</td>

          <td><input type="password" name="repeatPassword" required></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button type="submit">Créer</button>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>




<?php

  $content = ob_get_clean();
  require("view/template.php");

?>
