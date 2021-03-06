<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/Comment.php';

final class CommentsComponent extends Component {

    private $_comments;

    public function __construct ( array $picture ) {
        $pic_id = $picture['id'];
        $comments = Comment::get_all_items_by(array('picture_id' => $pic_id));
        foreach ($comments as $comment) {
            $this->_comments[] = new CommentComponent($comment, $picture);
        }
    }

    public function __invoke() {
        echo '
            <div class="comments">
        ';
        if (count($this->_comments)) {
            foreach ($this->_comments as $comment) {
                $comment();
            }
        }
        echo '<div>';
    }
}

 ?>
