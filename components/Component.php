<?php

abstract class Component {

    public function need_to_refresh() {
        return $this->_need_to_refresh || false;
    }

}

?>
