<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Comment.class.php';

final class CommentCountComponent extends Component {

    private $_comments_count;

    public function __construct ( array $picture ) {
        $comments = Comment::get_all_items_by(array('picture_id' => $picture['id']));
        $this->_comments_count = count($comments);
    }

    public function __invoke() {
        echo '
            <span class="comments-count">' . $this->_comments_count . ' <i class="icon-comment"></i></span>';
    }
}
