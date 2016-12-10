<?php
session_start();

require_once dirname(__FILE__) . '/components/Meta.php';
require_once dirname(__FILE__) . '/components/Menu.php';
require_once dirname(__FILE__) . '/components/Footer.php';
require_once dirname(__FILE__) . '/components/PicturePage.php';

$meta       = new MetaComponent();
$menu       = new MenuComponent();
$footer     = new FooterComponent();
$picture    = new PicturePageComponent();

?>
<!doctype html>
<html lang="fr">
    <head>
        <?php $meta(); ?>
    </head>
    <body>
        <header>
            <?php $menu(); ?>
        </header>
        <div class="picture-container">
            <?php $picture(); ?>
        </div>
        <footer>
            <?php $footer(); ?>
        </footer>
    </body>
</html>
