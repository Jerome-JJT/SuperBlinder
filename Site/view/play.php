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

$title = "SuperBlinder - Jeu";
$tracksDir = "/tracks/";

?>

<script>
  var timeout = 10;
</script>

<div class="page-center generator-tricols" style="height: 600px">

  <div style="width: 10%"></div

  ><div style="width: 2%"></div

  ><div style="width: 50%; height: 100%;">
    <div class="game-container">
      <p id="indic-text" style="text-align: center">
        Cliquez pour démarrer la musique
      </p>
      <div class="video-container">
        <video id="audio" style="width: 0">
         <source src="<?=$tracksDir.$gameUrl?>" type="video/mp4">
        </video>
        <video id="video" style="visibility: hidden; width: 100%; max-height: 350px" muted>
         <source src="<?=$tracksDir.$gameUrl?>" type="video/mp4">
        </video>
      </div>

      <h4 id="remaining-time" style="text-align: center"></h4>

      <div id="selection" style="margin-bottom: 30px; visibility: hidden">
        <?php foreach($answerList[0] as $answer):
          ?><div onclick="document.getElementById('answer').value='<?=$answer["key"]?>';hideOptions();timeout=1;"><div><?=$answer["value"]?></div></div><?php
          endforeach ?>
          <br>
        <?php foreach($answerList[1] as $answer):
          ?><div onclick="document.getElementById('answer').value='<?=$answer["key"]?>';hideOptions();timeout=1;"><div><?= $answer["value"] ?></div></div><?php
          endforeach ?>
      </div>

      <form id="answerForm" method="GET" style="text-align: center">
        <input type="hidden" name="page" value="play">
        <input id="answer" type="hidden" name="answer" value="-1">

        <button type="submit">Passer</button>
      </form>
    </div>
  </div

  ><div style="width: 2%"></div

  ><div style="width: 36%; height: 100%">
    <div class="game-side">
      <div>
        <h4>Code de la partie</h4>
        <p><?=$gameCode?></p>
        <p><?=$goodAnswers?> bonne(s) réponse(s) sur <?=$answered?> - <?=$scoreRatio?>%</p>

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
  function hideOptions()
  {
    document.getElementById("selection").style.visibility = "hidden";
  }

  document.getElementsByTagName("body")[0].onclick = function()
  {
    //Hide indication text
    document.getElementById("indic-text").style.display = "none";

    //Start audio and display options
    document.getElementsByTagName("body")[0].onclick = "";
    document.getElementById("audio").play();
    document.getElementById("selection").style.visibility = "visible";

    //Display remaining time
    document.getElementById("remaining-time").textContent = timeout+" secondes restantes";

    let timer = setInterval(function() {
      timeout-=1;

      //Display remaining time accorded
      if(timeout > 1){
        document.getElementById("remaining-time").textContent = timeout+" secondes restantes";
      }
      else if(timeout >= 0)
      {
        document.getElementById("remaining-time").textContent = timeout+" seconde restante";
      }

      //If timer finished, hide options and display answer's video
      if(timeout == -1){
        document.getElementById("remaining-time").textContent = "Fin";
        hideOptions();
        document.getElementById("video").style.visibility = "visible";
        document.getElementById("video").play();
      }

      //After 5 seconds, skips by sending wrong answer
      if(timeout < -5){
        document.getElementById("answerForm").submit();
      }
    }, 1000);
  }
</script>


<?php

  $content = ob_get_clean();
  require("view/template.php");

?>
