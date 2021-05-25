<?php

ob_start();

$title = "SuperBlinder - Générateur";


$error = isset($_SESSION["filling"]["generationError"]) ? $_SESSION["filling"]["generationError"] : "";

?>

<div class="page-center">

  <div class="generator-tricols">
    <h2 style="text-align: center">Nouvelle partie</h2>

    <p style="text-align:center; color: red">
      <?=$error?>
    </p>

    <div style="width: 40%">
      Choississez vos réglages pour votre partie de blind test
    </div

    ><div style="width: 15%"></div

    ><div style="width: 45%">
      <form method="POST" action="?action=generateGame">
        <table>
          <col width="50%">
          <col width="50%">

          <tr>
            <td><label for="difficulty"><strong id="difficulty-text">Normal</strong></label></td>
            <td><input id="difficulty" name="difficulty" type="range" onchange="updateText()" min="1" max="5" value="3"></td>
          </tr>

          <tr>
            <td><label for="trackNb"><strong>Nombre</strong></label></td>
            <td>
              <select id="trackNb" name="trackNb">
                <option value="10">10</option>
                <option value="20">20</option>
              </select>
            </td>
          </tr>

          <tr>
            <td><label for="type"><strong>Types</strong></label></td>
            <td>
              <select id="type" name="type">
                <option value="all">Tous</option>
                <option value="movie">Films</option>
                <option value="serie">Séries</option>
              </select>
            </td>
          </tr>

          <tr>
            <td></td>
            <td><button type="submit">Démarrer</button></td>
          </tr>
        </table>
      </form>
    </div>
  </div>


  <hr style="width: 80%; border: 2px solid black">


  <div class="generator-tricols">
    <h2 style="text-align: center">Partie déjà existante</h2>

    <div style="width: 40%">
      Vous pouvez rejoindre une partie de blind test déjà générée si vous avez son code
    </div

    ><div style="width: 15%">
    </div

    ><div style="width: 45%">
      <form method="POST" action="?action=searchGame">
        <table>
          <col width="50%">
          <col width="50%">

          <tr>
            <td><label for="code"><strong>Code</strong></label></td>
            <td><input id="code" name="code" type="text"></td>
          </tr>

          <tr>
            <td></td>
            <td><button type="submit">Chercher</button></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <br>
  <br>
</div>

<h2 style="text-align: center">Règles du jeu</h2>
<p style="margin: 0 4%">
  Règles : Le but d'une partie de « blind-test » (« test à l'aveugle ») est de retrouver le titre et l'artiste des musiques ou chansons diffusées par la vidéo.
  Vous gagnez un point par bonne réponse. Le but étant d'avoir le plus de points à la fin.

  Pour jouer il vous suffit de démarre le blind test et de cliquer sur le site pour lancer la video. Il y aura certains boutons avec des titres de la catégorie choisie et il faudra choisir le bon et cliquer dessus.
  Une fois le bouton cliqué ou bien le temps imparti fini, la video suivante est lancée.
  L'historique est marqué à droite ainsi que le pourcentage de bonne réponse.
</p>



<script>
  function updateText()
  {
    let text = document.getElementById("difficulty-text");

    let value = document.getElementById("difficulty").value;

    switch(value)
    {
      case "1":
        text.textContent = "Facile";
        break;

      case "2":
        text.textContent = "Facile-Normal";
        break;

      default:
      case "3":
        text.textContent = "Normal";
        break;

      case "4":
        text.textContent = "Normal-Difficile";
        break;

      case "5":
        text.textContent = "Difficile";
        break;
    }
  }

</script>



<?php

  $content = ob_get_clean();
  require("view/template.php");

?>
