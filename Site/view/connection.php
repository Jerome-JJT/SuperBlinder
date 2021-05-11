<?php

ob_start();

$title = "SuperBlinder - Connexion";

?>


<div id="login-page">
  <p style="text-align:center">
    Merci de vous connecter pour accéder au site
  </p>


  <div class="login-block">
    <h3>Connexion</h3>

    <form method="POST" action="?action=loginAccount">
      <table class="login-table">
        <tr>
          <td>Adresse mail</td>

          <td><input type="text" name="email" value="" required></td>
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

          <td><input type="text" name="email" value="" required></td>
        </tr>
        <tr>
          <td>Username</td>

          <td><input type="text" name="username" value="" required></td>
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
