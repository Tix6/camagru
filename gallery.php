<?php
session_start();

require dirname(__FILE__) . '/components/Meta.php';
require dirname(__FILE__) . '/components/Menu.php';
require dirname(__FILE__) . '/components/Footer.php';
require dirname(__FILE__) . '/components/Gallery.php';

$meta   = new MetaComponent();
$menu   = new MenuComponent();
$gallery = new GalleryComponent();
$footer = new FooterComponent();

function redirect() {
    header("refresh:5;url=index.php");
}

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
    <div class="gallery-wrap">
        <h1>Camagru</h1>
        <h2>Gallerie</h2>
        <div class="gallery">
            <?php $gallery(); ?>
        </div>
    </div>
    <footer>
        <?php $footer(); ?>
    </footer>
</body>
