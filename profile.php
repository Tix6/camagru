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

$pics = Picture::get_all_items_by(array('user_id' => $user_array['id']));

/* -------------------------------------------------------------------------- */
/* COMMENT ------------------------------------------------------------------ */

require_once dirname(__FILE__) . '/ressources/Comment.class.php';

$comments = Comment::get_all_items_by(array('user_id' => $user_array['id']));
$commented_pics = array();

if ($comments) {
    foreach ($comments as $c) {
        $commented_pics[] = Picture::get_item_by(array('id' => $c['picture_id']));
    }
}

$comments_received = 0;

if ($pics) {
    foreach ($pics as $p) {
        $comments_received += $p['comments'];
    }
}

/* -------------------------------------------------------------------------- */
/* LIKE ----------------------------------------------------------------------*/

require_once dirname(__FILE__) . '/ressources/Like.class.php';

$likes = Like::get_all_items_by(array('user_id' => $user_array['id']));
$liked_pics = array();

if ($likes) {
    foreach ($likes as $l) {
        $liked_pics[] = Picture::get_item_by(array('id' => $l['picture_id']));
    }
}

$likes_received = 0;

if ($pics) {
    foreach ($pics as $p) {
        $likes_received += $p['likes'];
    }
}

/* -------------------------------------------------------------------------- */
/* COMPONENTS --------------------------------------------------------------- */

require_once dirname(__FILE__) . '/components/Meta.php';
require_once dirname(__FILE__) . '/components/Menu.php';
require_once dirname(__FILE__) . '/components/Footer.php';

$meta       = new MetaComponent();
$menu       = new MenuComponent();
$footer     = new FooterComponent();


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
        <div class="profile-container">
            <h1><?php echo ucfirst($user_array['name']); ?></h1>
            <hr>
            <div>
            <h2>Stats</h2>
                <div class="stats">
                    <p><?php echo count($pics); ?><i class="icon-folder-open-empty"></i></p>
                    <p><?php echo $likes_received; ?><i class="icon-heart"></i></p>
                    <p><?php echo $comments_received; ?><i class="icon-comment-1"></i></p>
                </div>
            </div>
            <div>
            <h2>Ajouts</h2>
            <?php
            if ($pics) {
                echo '<ul>';
                foreach ($pics as $p) {
                    echo "<li>
                    <a href=\"picture.php?id={$p['url_id']}\">{$p['title']}</a>
                    </li>";
                }
                echo '</ul>';
            } else {
                echo "<p>Aucun ajout.</p>";
            }
            ?>
            </div>
            <div>
            <h2>Likes</h2>
            <?php
            if ($likes) {
                echo '<ul>';
                foreach ($liked_pics as $l) {
                    echo "<li>
                    <a href=\"picture.php?id={$l['url_id']}\">{$l['title']}</a>
                    </li>";
                }
                echo '</ul>';
            } else {
                echo "<p>Aucun ajout.</p>";
            }
            ?>
            </div>
            <div>
            <h2>Comments</h2>
            <?php
            if ($likes) {
                echo '<ul>';
                foreach ($commented_pics as $c) {
                    echo "<li>
                    <a href=\"picture.php?id={$c['url_id']}\">{$c['title']}</a>
                    </li>";
                }
                echo '</ul>';
            } else {
                echo "<p>Aucun ajout.</p>";
            }
            ?>
            </div>
        </div>
        <footer>
            <?php $footer(); ?>
        </footer>
    </body>
</html>
