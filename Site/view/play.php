<?php

ob_start();

$title = "SuperBlinder - Jeu";

?>

<div class="page-center generator-tricols" style="height: 600px">

  <div style="width: 10%"></div

  ><div style="width: 2%"></div

  ><div style="width: 50%; height: 100%;">
    <div class="game-container">
      <div class="video-container">
        <video style="width: 100%; max-height: 400px">
         <source src="/view/content/vids/audio.mp4" type="video/mp4">
        </video>
      </div>


      <div class="selection" style="margin-bottom: 30px; visibility: hidden">
        <div><div style="">Star Wars</div></div
        ><div><div>Narnia</div></div
        ><div><div>Seigneur des anneaux</div></div>
        <br>
        <div><div>Avengers</div></div
        ><div><div>Harry Potter</div></div
        ><div><div>Jurassic Park</div></div>
      </div>
    </div>
  </div

  ><div style="width: 2%"></div

  ><div style="width: 36%; height: 100%">
    <div class="game-side">
      <div>
        <h3>Code de la partie</h3>
        <p>sfhdgncncn</p>
        <p>1 bonne réponse sur 2 - 50%</p>
      </div

      ><div class="game-list">
        <div style="background-color: lime;">Star wars</div>
        <div style="background-color: red;">Seigneur des anneaux</div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementsByTagName("body")[0].onclick = function()
  {
    document.getElementsByTagName("video")[0].play();
    document.getElementsByClassName("selection")[0].style.visibility = "visible";
  }
</script>


<?php

  $content = ob_get_clean();
  require("view/template.php");

?>
