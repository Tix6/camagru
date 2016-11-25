<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Like.class.php';

final class LikeComponent extends Component {

    private $_picture;

    private $_user;
    private $_user_is_auth  = false;

    private $_like;
    private $_is_liked      = false;

    private function _check_auth() {
        if ($this->_user)
            $this->_user_is_auth = true;
    }

    private function _check_like() {
        if ($this->_user_is_auth === true) {
            $user_id = $this->_user['id'];
            $pic_id = $this->_picture['id'];
            $this->_like = Like::get_item_by(array('user_id' => $user_id, 'picture_id' => $pic_id));
            if ($this->_like !== false)
                $this->_is_liked = true;
        }
    }

    public function __construct ( array $picture, $user ) {
        $this->_picture = $picture;
        $this->_user = $user;
        $this->_check_auth();
        $this->_check_like();
    }

    public function __invoke() {
        $pic = $this->_picture;
        $like = $this->_like;
        if ($this->_user_is_auth === true) {
            if ($this->_is_liked === true) {
                echo '
                <span class="likes">' . $pic['likes'] . '
                    <form action="picture.php?id=' . $pic['url_id'] . '&like=del" method="POST">
                        <input type="hidden" name="like_id" value="' . $like['id'] . '">
                        <button type="submit" class="icon-heart liked"></button>
                    </form>
                </span>
                ';
            } else {
                echo '
                <span class="likes">' . $pic['likes'] . '
                    <a href="picture.php?id=' . $this->_picture['url_id'] . '&like=add">
                        <i class="icon-heart"></i>
                    </a>
                </span>
                ';
            }
        } else {
            echo '
            <span class="likes">' . $pic['likes'] . ' <i class="icon-heart"></i></span>
            ';
        }
    }
}
