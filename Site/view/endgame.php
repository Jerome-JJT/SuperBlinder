<?php

ob_start();

$title = "SuperBlinder - Jeu";
$tracksDir = "/tracks/";

?>

<div class="page-center generator-tricols" style="height: 600px">

  <div style="width: 20%"></div

  ><div style="width: 60%; height: 100%">
    <div class="game-side" style="text-align: center">
      <h2>Fin de partie</h2>

      <button style="text-align: center; max-width: 160px; margin: auto;" class="btn btn-grey" onclick="window.location='/'">Retour au site</button><br>
      <br>
      <div>
        <h4>Code de la partie</h4>
        <p><?= $gameCode ?></p>
        <p><?=$goodAnswers?> bonne(s) réponse(s) sur <?= $answered ?> - <?=$scoreRatio?>%</p>

        <h4>Score</h4>
      </div

      ><div class="game-list">
        <?php foreach($history as $hist): ?>
          <div style="background-color: <?= $hist['state'] == 1 ? 'lime' : 'red' ?>">
            <?= $hist["text"] ?>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</div>

<?php if(!isset($notGame)): ?>
  <script>
    document.getElementsByTagName("body")[0].onclick = function()
    {
      document.getElementsByTagName("body")[0].onclick = "";
      document.getElementById("audio").play();
      document.getElementById("selection").style.visibility = "visible";

      let timeout = 10;
      document.getElementById("remaining-time").textContent = timeout+" secondes restantes";

      let timer = setInterval(function() {
        timeout-=1;

        if(timeout > 1){
          document.getElementById("remaining-time").textContent = timeout+" secondes restantes";
        }
        else if(timeout >= 0)
        {
          document.getElementById("remaining-time").textContent = timeout+" seconde restante";
        }

        if(timeout == -1){
          document.getElementById("remaining-time").textContent = "Fin";
          document.getElementById("selection").style.visibility = "hidden";
          document.getElementById("video").style.visibility = "visible";
          document.getElementById("video").play();
        }

        if(timeout < -5){
          window.location = "/?page=play&answer=-1";
        }
      }, 1000);
    }
  </script>
<?php endif ?>


<?php

  $content = ob_get_clean();
  require("view/template.php");

?>
