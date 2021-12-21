<?php
ini_set('display_errors','on');
error_reporting(E_ALL);
require_once 'inc/Config.php';
require_once 'inc/Connector.php';
require_once 'inc/Global.php';
require_once 'inc/Functions.php';
require_once 'controllers/form.php';
?>
<html lang="fr">
<head> 
    <!-- Métadonnées -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="John Doe">
    <meta name="description" content="Découvrez qui se cache derrière les anos.">
    <!-- Lien JavaScript-->
    <script src="assets/js/app.js"></script>
    <!-- Lien CSS -->
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font.css">
  <!-- Icone -->
    <link rel="icon" type="image/png" href="https://wolfy.fr/static/img/assets/favicon-96x96.png" sizes="96x96" />
    <title><?= NAME_SITE ?></title>
</head>
  <style>
    .modal-content{
  color:white;max-width: 700px;background-color: #242433;border-radius: 12px;border: 20px solid #242433;
 }
.modal-content .modal-header .spanTutorial{
  background: #13131b;font-size: 15px;float:left;margin-top: -39px;
}
 .modal-body .modalContainer{
  background-color: #1a1a24;border-radius: 12px;padding: 4%; 
}
 code{
   color: #df986f;
   background-color: #202124;
   padding: 2px;
    }
  </style>
<body>
    <div  class="container" align="center">
      <div class="header">
        <h1><?= NAME_SITE ?></h1>
        <p style="color: white;text-align: center;">Ce site n'appartient pas et n'est pas affilié à Wolfy.</p>
      <div class="searchUser">
        <span class="badge rounded-pill searchSpan">Recherche <img src="https://wolfy.fr/static/img/icons/questionMark.svg" style="width: 13px;margin-left: 7px;cursor:pointer;"  data-toggle="modal" data-target="#basicModal"></span>
        <!-- basic modal -->
         <div class="modal fade" id="basicModal" tabindex="-1" aria-labelledby="moreInfoGameModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                    <span class="badge rounded-pill spanTutorial">Tutoriel</span>
                </div>
                <div class="modal-body" >
                <div class="modalContainer">
                  <h4>Comment avoir l'ID d'un joueur anonyme en partie.</h4>
                  <h5>Etape 1 :</h5>
                  <p>Faites un clique droit sur le skin du joueur en anonyme en partie.</p>
                  <h5>Etape 2 :</h5>
                  <p>Cliquez sur "Inspecter l'élément".</p>
                  <h5>Etape 3 :</h5>
                  <p>Double cliquez sur <code>Character_characterHitbox__2d6iP</code>.</p>
                  <h5>Etape 4 :</h5>
                  <p>Dans la balise <code>&#60img class="Character_characterImg__1iXNS" src="/api/skin/render/user.svg?id=<span style="font-weight: bold;color: white;">fd7de17c-fd65-4545-9f1e-5e9e9854e7cf</span>&amp;v=0WAKVKC9T1&s=411d5c54-3657-4a45-8ebc-5a9518b85ce8" draggable="false"&#62</code>, ne copiez que ce qui est en gras et blanc.</p>
                  <h5>Etape 5 :</h5>
                  <p>Collez l'ID dans le champ et le tour est joué. 😊</p>
                  <div class="modal-footer">
                   <button type="button" class="btn-custom" data-dismiss="modal">J'ai compris</button>
                </div>
                </div>
                </div>
              </div>
            </div>
          </div>

        <div class="searchUserContainer">
        <form method="post">
          <div class="input-container">
             <i class="icon"><img class="searchSVG" src="https://wolfy.fr/static/img/icons/search.svg" alt=""></i>
            <input class="input-custom" name="player" type="text" placeholder="Entrez l'ID d'un joueur..." autocomplete="off" <?php if(isset($_POST['player'])){ ?>value="<?php echo $_POST['player']; ?>"<?php } ?>>
          </div>
          <button class="btn-custom2" type="submit" name="submit">Valider</button>
          </form>
    <small style="font-style: italic;font-weight: lighter;color:#d2d2d2;">* Cliquez sur  <img src="https://wolfy.fr/static/img/icons/questionMark.svg" style="width: 13px;"> pour ouvrir le tutoriel.</small>
       <small style="display: inline-block;font-style: italic;font-weight: lighter;color:#d2d2d2;">* La recherche peut prendre un certain temps, ne rafraîchissez pas la page si elle charge encore.</small>
          
        </div>
      </div>
        </div><br>
        <?php if(isset($_POST['submit'])) { ?>
          <?php if(isset($_SESSION['error'])){?>
      <div style="background-color: #C13E47;color:white;padding: 5px;border-radius: 12px;max-width: 700px;box-shadow: 0 3px 6px rgb(0 0 0 / 16%);" class="alert alert-dark" role="alert">
      <?php echo $_SESSION['error'];unset($_SESSION['error']); ?>
    </div>
		<?php }else { ?>
        <div class="userInfo">
        <span class="badge rounded-pill userSpan">Résultat</span>
        <div class="userInfoContainer">
        <div class="userNameSkin" style="background: -webkit-gradient(linear,left bottom,left top,from(<?php echo Ranking($re->user->rank)['background-skin-2']; ?>),to(<?php echo Ranking($re->user->rank)['background-skin-1']; ?>))">
            <div class="lvlCount" style="background: linear-gradient(200deg,<?php echo Ranking($re->user->rank)['background-lvl-1']; ?>,<?php echo Ranking($re->user->rank)['background-lvl-2']; ?>);box-shadow: 0 1px 6px <?php echo Ranking($re->user->rank)['background-lvl-3']; ?>;">
            <small><?php echo $re->user->niveau; ?></small> 
         </div>
            <img src="https://wolfy.fr/api/skin/render/user.svg?id=<?php echo $re->user->id; ?>&v=Q6GUTN0WNR&profile=right&size=small&s=0" alt="">
        </div>
        <span class="badge rounded-pill spanUsername"><?php echo $re->user->username; ?></span>
        </div>
        </div>
    <?php } ?>
  <?php } ?>
      </div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src='https://unpkg.com/popper.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js'></script>
  
</body>
</html>