<?php

ob_start();

$title = "SuperBlinder - Uploader";

$success = isset($_SESSION["filling"]["success"]) ? $_SESSION["filling"]["success"] : "";
$error = isset($_SESSION["filling"]["uploadError"]) ? $_SESSION["filling"]["uploadError"] : "";

?>

<div class="page-center" style="height: 600px">
  <p style="text-align:center; color: red">
    <?=$error?>
  </p>
  <p style="text-align:center; color: green">
    <?=$success?>
  </p>

  <div>
    <form method="POST" action="?action=upload" enctype="multipart/form-data">
      <h3 style="text-align: center">Upload</h3>

      <table class="login-table" style="width: 60%; margin-left: 20%; min-width: 300px">
        <tr>
          <td>Réponse</td>

          <td><input type="text" name="answer" value="" required></td>
        </tr>
        <tr>
          <td>Difficulté</td>

          <td>
            <select name="difficulty" required>
              <option value="Easy">Facile</option>
              <option value="Normal">Normal</option>
              <option value="Hard">Difficile</option>
            </select>
          </td>
        </tr>

        <tr>
          <td>Type</td>

          <td>
            <select name="type" required>
              <option value="Movie">Film</option>
              <option value="Serie">Série</option>
            </select>
          </td>
        </tr>

        <tr>
          <td>Vidéo</td>

          <td>
            <input type="file" name="video">
          </td>
        </tr>
      </table>
    </div>

    <!--<div style="height: 200px">
      <div style="display: inline-block; vertical-align: top; width: 49.5%">
        <h3 style="text-align: center">Vidéo</h3>

        <table class="login-table" style="width: 80%; margin-left: 10%;">
          <tr>
            <td>Vidéo</td>

            <td style="max-width: 50px; overflow: hidden">
              <input type="file" name="video">
            </td>
          </tr>
        </table>
      </div

      ><div style="display: inline-block; background-color: black; border: 1px solid black; border-radius: 80%; vertical-align: top; width: 1%; height: 100%">

      </div

      ><div style="display: inline-block; vertical-align: top; width: 49.5%">
        <h3 style="text-align: center">Image + son</h3>

        <table class="login-table" style="width: 80%; margin-left: 10%;">
          <tr>
            <td>Image</td>

            <td style="max-width: 50px; overflow: hidden">
              <input type="file" name="image">
            </td>
          </tr>

          <tr>
            <td>Son</td>

            <td style="max-width: 50px; overflow: hidden">
              <input type="file" name="audio">
            </td>
          </tr>
        </table>
      </div>-->


      <div>
        <table class="login-table" style="width: 80%; margin-left: 10%; min-width: 300px">
          <tr>
            <td colspan="2">
              <button type="submit">Envoyer</button>
            </td>
          </tr>
        </table>
      </div>
    </form>
  </div>
</div>




<?php

  $content = ob_get_clean();
  require("view/template.php");

?>
