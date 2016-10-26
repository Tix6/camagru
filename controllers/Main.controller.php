<?php

require_once dirname(__FILE__) . '/Controller.class.php';

final class Main_Ctrl extends Controller {

    private $_user;

    public function __construct() {
        // if (isset($args['id']) === TRUE)
        //     $this->_user = User::get_item_by_id($args['id']);
    }

    public function render() {
        echo "
<section>
<p>SECTION</p>
</section>
<aside>
<p>ASIDE</p>
</aside>
";
    }
}

?>
