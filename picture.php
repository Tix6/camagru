<?php
session_start();
//
// echo '$_GET' . PHP_EOL;
// print_r($_GET);
// echo '$_POST' . PHP_EOL;
// print_r($_POST);

/* USER --------------------------------------------------------------------- */

require_once dirname(__FILE__) . '/ressources/User.class.php';
$user_array = array();

if (isset($_SESSION['is_auth']) && isset($_SESSION['id'])) {
    $user_array = User::get_item_by(array('id' => $_SESSION['id']));
}

/* -------------------------------------------------------------------------- */
/* PICTURE ------------------------------------------------------------------ */

require_once dirname(__FILE__) . '/ressources/Picture.class.php';

$picture_url_id = (isset($_GET['id'])) ? $_GET['id'] : '0';
$picture_array  = Picture::get_item_by(array('url_id' => $picture_url_id));

/* -------------------------------------------------------------------------- */
/* COMMENT ------------------------------------------------------------------ */

require_once dirname(__FILE__) . '/ressources/Comment.class.php';

if ($user_array) {
    if (isset($_GET['comment'])) {
        switch ($_GET['comment']) {
            case 'add':
                $fields = Comment::get_fields();
                $sql_params = array_intersect_key($_POST, $fields);
                Comment::add_item($sql_params);
                break;
            case 'del':
                if ($user_array && $user_array['id'] === $_POST['comment_user_id'])
                    Comment::del_item_by_id($_POST['comment_id']);
                break;
            default:
                break;
        }
        header("Location: picture.php?id=$picture_url_id");
    }
}

/* -------------------------------------------------------------------------- */
/* LIKE ----------------------------------------------------------------------*/

require_once dirname(__FILE__) . '/ressources/Like.class.php';

if (isset($_GET['like'])) {
    switch ($_GET['like']) {
        case 'add':
            Like::add_item(array('user_id' => $user_array['id'], 'picture_id' => $picture_array['id']));
            break;
        case 'del':
            if ($user_array && $user_array['id'] === $_POST['like_user_id'])
                Like::del_item_by_id($_POST['like_id']);
            break;
        default:
            break;
    }
    header("Location: picture.php?id=$picture_url_id");
}

/* -------------------------------------------------------------------------- */
/* COMPONENTS --------------------------------------------------------------- */

require_once dirname(__FILE__) . '/components/Meta.php';
require_once dirname(__FILE__) . '/components/Menu.php';
require_once dirname(__FILE__) . '/components/Footer.php';

require_once dirname(__FILE__) . '/components/Picture.php';
require_once dirname(__FILE__) . '/components/AddComment.php';
require_once dirname(__FILE__) . '/components/Comments.php';

$meta       = new MetaComponent();
$menu       = new MenuComponent();
$footer     = new FooterComponent();

$components = array(
    'picture'       => new PictureComponent($picture_array, $user_array),
    'comments'      => new CommentsComponent($picture_array, $user_array),
    'add_comment'   => new AddCommentComponent($picture_array, $user_array)
);

foreach ($components as $comp) {
    if ($comp->need_to_refresh() === true)
        header("Location: picture.php?id=$picture_url_id");
}

/* -------------------------------------------------------------------------- */
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
            <?php $components['picture'](); ?>
            <?php $components['comments'](); ?>
            <?php $components['add_comment'](); ?>
        </div>
        <footer>
            <?php $footer(); ?>
        </footer>
    </body>
</html>
