<?php
session_start();

require_once dirname(__FILE__) . '/components/Meta.php';
require_once dirname(__FILE__) . '/components/Menu.php';
require_once dirname(__FILE__) . '/components/Footer.php';

$meta       = new MetaComponent();
$menu       = new MenuComponent();
$footer     = new FooterComponent();

require_once dirname(__FILE__) . '/components/Picture.php';
require_once dirname(__FILE__) . '/components/AddComment.php';
require_once dirname(__FILE__) . '/components/Comments.php';
require_once dirname(__FILE__) . '/ressources/Picture.class.php';

$picture_url_id = (isset($_GET['id'])) ? $_GET['id'] : '0';
$picture_array  = Picture::get_item_by(array('url_id' => $picture_url_id));

$components = array(
    'picture'       => new PictureComponent($picture_array),
    'comments'      => new CommentsComponent($picture_array['id']),
    'add_comment'   => new AddCommentComponent($picture_array)
);

if (isset($_GET['delete'])) {
    if (isset($_SESSION) && $_SESSION['id'] === $picture_array['user_id']) {
        Comment::del_item_by_id($_GET['delete']);
    }
    header("Location: picture.php?id=$picture_url_id");
}

foreach ($components as $comp) {
    if ($comp->need_to_refresh() === true)
        header("Location: picture.php?id=$picture_url_id");
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
  <div class="container picture-container">
      <?php $components['picture'](); ?>
      <?php $components['comments'](); ?>
      <?php $components['add_comment'](); ?>
  </div>
  <footer>
     <?php $footer(); ?>
  </footer>
</body>
</html>
