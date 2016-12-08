<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/Like.php';
require_once dirname(__FILE__) . '/CommentCount.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class PictureComponent extends Component {

    private $_picture;
    private $_author;
    private $_error = false;
    private $_like_component;

    private function _parse_date ($raw) {
        $date = date_parse($raw);
        return "{$date['day']}/{$date['month']}/{$date['year']}";
    }

    public function __construct ( array $picture, $user = array() ) {
        if ($picture) {
            $this->_picture = $picture;
            $this->_author = User::get_item_by(array('id' => $this->_picture['user_id']));
            $this->_like_component = new LikeComponent($picture, $user);
            $this->_comment_component = new CommentCountComponent($picture);
        } else {
            $this->_error = true;
        }
    }

    public function __invoke() {
        if ($this->_error) {
            echo 'Cette image n\'existe pas.';
        } else {
            $pic = $this->_picture;
            $date = $this->_parse_date($pic['creation']);
            $author = ucfirst($this->_author['name']);
            echo '
            <div class="picture-component">
                <h2 class="title">' . ucfirst($pic['title']) . '</h2>
                <figure>
                    <a href="picture.php?id='. $pic['url_id'] .'"><img src="' . $pic['path'] . '" alt="' . $pic['title'] . '"></a>
                </figure>
                <div class="picture-info">
                    <div class="left">
                        <a href="profile.php?user=' . $this->_author['id'] . '">' . $author . '</a>
                    </div>
                    <div class="right">';
            ($this->_comment_component)();
            ($this->_like_component)();
            echo '
                    </div>
                </div>
            </div>
            ';
        }
    }
}

 ?>
