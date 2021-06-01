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


<?php

  $content = ob_get_clean();
  require("view/template.php");

?>
