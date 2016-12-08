<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Comment.class.php';

final class AddCommentComponent extends Component {

    private $_picture_id;
    private $_user;

    const MAX_LENGTH_COMMENT = 200;

    public function __construct ( array $picture, $user ) {
        $this->_picture = $picture;
        $this->_user = $user;
    }

    public function __invoke() {
        if ($this->_user) {
            echo '
            <div class="add-comment">
                <form action="picture.php?id=' . $this->_picture['url_id'] . '&comment=add" method="POST">
                    <textarea name="comment" placeholder="Votre commentaire..." rows="4" minlength="2" maxlength="' . self::MAX_LENGTH_COMMENT . '"></textarea>
                    <input type="hidden" name="picture_id" value="' . $this->_picture['id'] . '">
                    <input type="hidden" name="user_id" value="' . $this->_user['id'] . '">
                    <button type="submit">Poster</button>
                </form>
            </div>
            ';
        } else {
            echo '<p class="error">Vous devez vous connecter pour poster un commentaire.</p>';
            echo '<a href="user.php?page=connect">Connectez vous ici.</a>';
        }
    }
}

 ?>
