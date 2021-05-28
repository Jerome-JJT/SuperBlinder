<?php

ob_start();

$title = "SuperBlinder - Jeu";
$tracksDir = "/tracks/";

?>

<div class="page-center generator-tricols" style="height: 600px">

  <div style="width: 10%"></div

  ><div style="width: 2%"></div

  ><div style="width: 50%; height: 100%;">
    <div class="game-container">

      <div class="video-container">
        <video id="audio" style="width: 0">
         <source src="<?=$tracksDir.$gameUrl?>" type="video/mp4">
        </video>
        <video id="video" style="visibility: hidden; width: 100%; max-height: 400px" muted>
         <source src="<?=$tracksDir.$gameUrl?>" type="video/mp4">
        </video>
      </div>

      <h4 id="remaining-time" style="text-align: center"></h4>

      <div id="selection" style="margin-bottom: 30px; visibility: hidden">
        <?php foreach($answerList[0] as $answer):
          ?><div onclick="window.location='/?page=play&answer=<?=$answer["key"]?>'"><div><?=$answer["value"]?></div></div><?php
          endforeach ?>
          <br>
        <?php foreach($answerList[1] as $answer):
          ?><div onclick="window.location='/?page=play&answer=<?=$answer["key"]?>'"><div><?= $answer["value"] ?></div></div><?php
          endforeach ?>
      </div>
    </div>
  </div

  ><div style="width: 2%"></div

  ><div style="width: 36%; height: 100%">
    <div class="game-side">
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


<?php

  $content = ob_get_clean();
  require("view/template.php");

?>
