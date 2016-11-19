<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Comment.class.php';

final class AddCommentComponent extends Component {

    private $_picture_id;
    private $_user_id = 0;
    private $_error = false;
    const MAX_LENGTH_COMMENT = 200;

    private function _check_comment() {

    }

    private function _update_database() {
        $fields = Comment::get_fields();
        $sql_params = array_intersect_key($_POST, $fields);
        Comment::add_item($sql_params);
    }

    public function __construct ( array $picture ) {
        $this->_picture = $picture;
        if (isset($_SESSION['is_auth']) && $_SESSION['is_auth'] === true) {
            $this->_user_id = $_SESSION['id'];
            if ($_POST['add-comment'] == 'ok') {
                $this->_update_database();
                $this->_need_to_refresh = true;
            }
        } else {
            $this->_error = true;
        }
    }

    public function __invoke() {
        if ($this->_error === true) {
            echo '<p class="error">Vous devez vous connecter pour poster un commentaire.</p>';
            echo '<a href="user.php?page=connect">connectez vous ici.</a>';
        } else {
            echo '
            <div class="add-comment">
                <form action="picture.php?id=' . $this->_picture['url_id'] . '" method="POST">
                    <textarea name="comment" placeholder="Votre commentaire..." rows="4" maxlength="' . self::MAX_LENGTH_COMMENT . '"></textarea>
                    <input type="hidden" name="picture_id" value="' . $this->_picture['id'] . '">
                    <input type="hidden" name="user_id" value="' . $this->_user_id . '">
                    <button type="submit" name="add-comment" value="ok">Poster</button>
                </form>
            </div>
            ';
        }
    }
}

 ?>
