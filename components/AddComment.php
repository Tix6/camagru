<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Comment.class.php';

final class AddCommentComponent extends Component {

    const NEED_AUTH             = true;
    const ACTION_NAME           = 'commenter';
    const MAX_LENGTH_COMMENT    = 200;

    private $_picture_id;

    public function __construct ( array $picture ) {
        parent::__construct();
        $this->_picture = $picture;
    }

    public function __invoke() {
        if (parent::__invoke() === true) {
            echo '
            <div class="add-comment">
                <form action="picture.php?id=' . $this->_picture['url_id'] . '&comment=add" method="POST">
                    <textarea name="comment" placeholder="Votre commentaire..." rows="4" minlength="2" maxlength="' . self::MAX_LENGTH_COMMENT . '"></textarea>
                    <button type="submit">Poster</button>
                </form>
            </div>
            ';
        }
    }
}

 ?>
