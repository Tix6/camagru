<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Like.class.php';

final class LikeComponent extends Component {

    private $_mini_mode;

    private $_picture;

    private $_likes_count;
    private $_user_like;

    private function _check_like() {
        $pic_id = $this->_picture['id'];
        $likes = Like::get_all_items_by(array('picture_id' => $pic_id));
        $this->_likes_count = count($likes);
        if ($this->_user_is_auth === true) {
            $user_id = $_SESSION['id'];
            foreach ($likes as $like) {
                if ($like['user_id'] == $user_id)
                    $this->_user_like = $like;
            }
        }
    }

    public function __construct ( $picture, $mini = false ) {
        parent::__construct();
        $this->_picture = $picture;
        $this->_check_like();
        $this->_mini_mode = $mini;
    }

    public function __invoke() {
        $like = $this->_user_like;
        if ($this->_user_is_auth === true && $this->_mini_mode === false) {
            if ($like) {
                echo '
                <span class="likes">' . $this->_likes_count . '
                    <a class="del" href="picture.php?id=' . $this->_picture['url_id'] . '&like=del"><i class="icon-heart-broken"></i></a>
                </span>
                ';
            } else {
                echo '
                <span class="likes">' . $this->_likes_count . '
                    <a class="add" href="picture.php?id=' . $this->_picture['url_id'] . '&like=add"><i class="icon-heart"></i></a>
                </span>
                ';
            }
        } else {
            echo '
            <span class="likes">' . $this->_likes_count . ' <i class="icon-heart"></i></span>
            ';
        }
    }
}
