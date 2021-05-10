<?php

ob_start();

$title = "SuperBlinder - Générateur";

?>

<div class="page-center">

  <div class="generator-tricols">
    <h2 style="text-align: center">Nouveau blind test</h2>

    <div style="width: 40%">
      Choississez vos réglages pour votre blind test
    </div

    ><div style="width: 15%"></div

    ><div style="width: 45%">
      <form method="POST" action="?action=createGame">
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
                <option>10</option>
                <option>20</option>
              </select>
            </td>
          </tr>

          <tr>
            <td><label for="type"><strong>Types</strong></label></td>
            <td>
              <select id="type" name="type">
                <option>Tous</option>
                <option>Films</option>
                <option>Séries</option>
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
    <h2 style="text-align: center">Blind test déjà existant</h2>

    <div style="width: 40%">
      Vous pouvez rejoindre un blind test déjà généré si vous avez son code
    </div

    ><div style="width: 15%">
    </div

    ><div style="width: 45%">
      <form method="POST" action="?action=joinGame">
        <table>
          <col width="50%">
          <col width="50%">

          <tr>
            <td><label for="code"><strong>Code</strong></label></td>
            <td><input id="code" name="code" type="text"></td>
          </tr>

          <tr>
            <td></td>
            <td><button type="submit">Rechercher</button></td>
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
  Règles :
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
