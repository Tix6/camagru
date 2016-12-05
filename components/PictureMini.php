<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/Like.php';
require_once dirname(__FILE__) . '/CommentCount.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class PictureMiniComponent extends Component {

    private $_picture;
    private $_error = false;
    private $_like_component;

    public function __construct ( array $picture ) {
        if ($picture) {
            $this->_picture = $picture;
            $this->_like_component = new LikeComponent($picture, $user);
            $this->_comment_component = new CommentCountComponent($picture);
        } else {
            $this->_error = true;
        }
    }

    public function __invoke() {
        if ($this->_error) {
            echo '';
        } else {
            $pic = $this->_picture;
            echo '
            <div class="picture-mini">
                <a class="picture-info-hover" href="picture.php?id='. $pic['url_id'] .'">
                    <span style="width: 100%; text-align: center;">';
                ($this->_comment_component)();
                ($this->_like_component)();
                echo '
                    </span>
                </a>
                <figure>
                    <img src="' . $pic['path'] . '" alt="' . $pic['title'] . '">
                </figure>
                </a>
            </div>';
        }
    }
}

 ?>
