<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class UserComponent extends Component {

    private $_user;
    private $_pic_count;
    private $_like_count;
    private $_comment_count;

    public function __construct ( $user ) {
        if ($user) {
            $this->_user = $user;
            $this->_pic_count = count(Picture::get_all_items_by(array('user_id' => $user['id'])));
            $this->_like_count = count(Like::get_all_items_by(array('user_id' => $user['id'])));
            $this->_comment_count = count(Comment::get_all_items_by(array('user_id' => $user['id'])));
        }
    }

    public function __invoke() {
        $username = ucfirst($this->_user['name']);
        echo '
        <div class="user">
            <h1>' . $username . '</h1>
            <div class="stats">
            <span><strong>' . $this->_pic_count . '</strong> publications</span>
            <span><strong>' . $this->_like_count . '</strong> likes</span>
            <span><strong>' . $this->_comment_count . '</strong> commentaires</span>
            </div>
        </div>';
    }
}

 ?>
