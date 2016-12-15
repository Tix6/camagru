<?php

require_once dirname(__FILE__) . '/../ressources/Picture.class.php';
require_once dirname(__FILE__) . '/../ressources/Comment.class.php';
require_once dirname(__FILE__) . '/../ressources/Like.class.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';
require_once dirname(__FILE__) . '/../mail/Mailer.class.php';
require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/Picture.php';
require_once dirname(__FILE__) . '/AddComment.php';
require_once dirname(__FILE__) . '/Comments.php';

final class PicturePageComponent extends Component {

    private $_picture;
    private $_user_auth;

    private $_add_comment_error = '';

    private function _send_comment_mail($comment) {
        $dest = User::get_item_by(array('id' => $this->_picture['user_id']));
        if ($dest && $dest['id'] != $this->_user_auth['id']) {
            $destname = ucfirst($dest['name']);
            $title = 'Camagru - Nouveau commentaire sur votre image.';
            $author = '<a href="http://' . $_SERVER['HTTP_HOST'] . '/camagru/profile.php?id='. $this->_user_auth['id'] .'">' . ucfirst($this->_user_auth['name']) . '</a>';
            $link = '<a href="http://' . $_SERVER['HTTP_HOST'] . '/camagru/picture.php?id=' . $this->_picture['url_id'] .'">Cliquez ici pour voir le commentaire.</a>';
            $message = "Bonjour $destname,<br><br>$author a commenté une de vos images :<br><br><i>\"$comment\"</i><br><br>$link";
            Mailer::send($dest['mail'], $title, $message);
        }
    }

    private function _comment_handler() {
        switch ($_GET['comment']) {
            case 'add':
                if (mb_strlen(trim($_POST['comment'])) > 200) {
                    $this->_add_comment_error = '<p class="alert-danger">Votre commentaire est trop long.</p>';
                    return ;
                }
                $params = array(
                    'comment' => $_POST['comment'],
                    'user_id' => $this->_user_auth['id'],
                    'picture_id' => $this->_picture['id']
                );
                if (Comment::add_item($params))
                    $this->_send_comment_mail($_POST['comment']);
                break;
            case 'del':
                if ($this->_user_auth['id'] === $_POST['comment_user_id'])
                    Comment::del_item_by(array('id' => $_POST['comment_id']));
                break;
            default:
                break;
        }
        $this->_redirect("picture.php?id={$this->_picture['url_id']}");
    }

    private function _like_handler() {
        $like = Like::get_item_by(array('user_id' => $this->_user_auth['id'], 'picture_id' => $this->_picture['id']));
        switch ($_GET['like']) {
            case 'add':
                if ($like === false)
                    Like::add_item(array('user_id' => $this->_user_auth['id'], 'picture_id' => $this->_picture['id']));
                break;
            case 'del':
                if ($like !== false)
                    Like::del_item_by(array('id' => $like['id']));
                break;
            default:
                break;
        }
        $this->_redirect("picture.php?id={$this->_picture['url_id']}");
    }

    private function _picture_handler() {
        if ($_GET['picture'] === 'del') {
            if ($this->_user_auth['id'] === $this->_picture['user_id']) {
                if (Picture::delete_picture_by_id($this->_picture['id']))
                    $this->_redirect("index.php");
            }
        }
    }

    public function __construct () {
        parent::__construct();

        if (isset($_GET['id']))
            $this->_picture = Picture::get_item_by(array('url_id' => $_GET['id']));
        else
            return ;

        if ($this->_user_is_auth === true) {
            $this->_user_auth = User::get_item_by(array('id' => $_SESSION['id']));
            if ($this->_user_auth) {
                if (isset($_GET['like']))
                    $this->_like_handler();
                else if (isset($_GET['comment']))
                    $this->_comment_handler();
                else if (isset($_GET['picture']))
                    $this->_picture_handler();
            }
        }

        if ($this->_picture) {
            $this->_picture_compo     = new PictureComponent($this->_picture);
            $this->_comments_compo    = new CommentsComponent($this->_picture);
            $this->_add_comment_compo = new AddCommentComponent($this->_picture);
        }
    }

    public function __invoke() {
        if ($this->_picture) {
            ($this->_picture_compo)();
            ($this->_comments_compo)();
            echo $this->_add_comment_error;
            ($this->_add_comment_compo)();
        } else {
            echo "<p class=\"error\">Il semblerait que cette image n'existe pas.</p>";
        }
    }
}

 ?>
