<?php
/*
** This file is simply a router
*/

session_start();

if (isset($_GET['page']))
{
    switch ($_GET['page']) {
        case 'register':
            require_once dirname(__FILE__) . '/controllers/Register.controller.php';
            $controller = new Register_Ctrl($_POST);
            break ;
        case 'connect':
            require_once dirname(__FILE__) . '/controllers/Connect.controller.php';
            $controller = new Connect_Ctrl();
            break ;
        case 'confirm':
            require_once dirname(__FILE__) . '/controllers/Confirm.controller.php';
            $controller = new Confirm_Ctrl(intval($_GET['id']), $_GET['token']);
            break ;
        default:
            require_once dirname(__FILE__) . '/controllers/Main.controller.php';
            $controller = new Main_Ctrl();
            break ;
    }
} else {
    require_once dirname(__FILE__) . '/controllers/Main.controller.php';
    $controller = new Main_Ctrl();
}

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Camagru</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Patrick+Hand+SC" rel="stylesheet">
</head>
<body>
  <header>
      <h1 class="title"><a href="index.php">Camagru</a></h1>
  </header>
  <div class="container">
      <?php
      $controller->render();
      ?>
  </div>
  <footer>
      <p>Réalisé dans le cadre d'un projet avec l'école 42. - dev by <a href="http://github.com/tix6" target="_blank">tix6</a></p>
  </footer>
</body>
</html>
