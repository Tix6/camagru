<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Like.class.php';

final class LikeComponent extends Component {

    private $_picture;
    private $_user;

    private function _check_auth() {
        if (isset($_SESSION['is_auth'])) {
            Like::get_item_by();
        }
    }

    public function __construct ( array $picture ) {
        $this->_picture = $picture;
        // $this->_check_auth();
    }

    public function __invoke() {
        $pic = $this->_picture;
        echo '
            <span class="likes">' . $pic['likes'] . ' <i class="icon-heart"></i></span>
        ';
    }
}
