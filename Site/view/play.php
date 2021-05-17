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
        <video id="audio" style="width: 0">
         <source src="/view/content/vids/audio.mp4" type="video/mp4">
        </video>
        <video id="video" style="visibility: hidden; width: 100%; max-height: 400px" muted>
         <source src="/view/content/vids/audio.mp4" type="video/mp4">
        </video>
      </div>

      <h4 id="remaining-time" style="text-align: center"></h4>

      <div id="selection" style="margin-bottom: 30px; visibility: hidden">
        <div><div>Star Wars</div></div
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
        <h4>Code de la partie</h4>
        <p>sfhdgncncn</p>
        <p>1 bonne réponse sur 2 - 50%</p>

        <h4>Score</h4>
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
    document.getElementsByTagName("body")[0].onclick = "";
    document.getElementById("audio").play();
    document.getElementById("selection").style.visibility = "visible";

    let timeout = 3;
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
        clearInterval(timer);
        return;
      }
    }, 1000);
  }
</script>


<?php

  $content = ob_get_clean();
  require("view/template.php");

?>
