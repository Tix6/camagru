<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/Like.php';
require_once dirname(__FILE__) . '/CommentCount.php';

final class PictureComponent extends Component {

    private $_picture;
    private $_author;
    private $_error = false;

    private function _parse_date ($raw) {
        $date = date_parse($raw);
        return "{$date['day']}/{$date['month']}/{$date['year']}";
    }

    public function __construct ( array $picture ) {
        parent::__construct();
        if ($picture) {
            $this->_picture = $picture;
            $this->_author = User::get_item_by(array('id' => $this->_picture['user_id']));
            $this->_like_component      = new LikeComponent($picture, false);
            $this->_comment_component   = new CommentCountComponent($picture);
        } else {
            $this->_error = true;
        }
    }

    private function _delete_link() {
        if ($this->_user_is_auth) {
            if ($_SESSION['id'] == $this->_author['id'] || isset($_SESSION['admin'])) {
                $script = "return confirm('Etes vous sûr de vouloir supprimer cette photo ?')";
                return '<a href="picture.php?id=' .$this->_picture['url_id']. '&picture=del" onclick="' . $script . '"><i class="icon-trash"></i> supprimer</a>';
            }
        }
        return '';
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
                <div class="top">
                    <h2 class="title">' . ucfirst($pic['title']) . '</h2>' .  $this->_delete_link() . '
                </div>
                <figure>
                    <a href="picture.php?id='. $pic['url_id'] .'"><img src="' . $pic['path'] . '" alt="' . $pic['title'] . '"></a>
                </figure>
                <div class="picture-info">
                    <div class="left">
                        <a href="profile.php?id=' . $this->_author['id'] . '">' . $author . '</a>
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
