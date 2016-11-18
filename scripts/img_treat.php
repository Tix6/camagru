<?php

final class Image_treat {
    private $_image;
    private $_sticker = array(
        'path' => '',
        'raw' => '',
        'resized' => '',
        'width' => 0,
        'height' => 0,
        'x' => 0,
        'y' => 0,
        'ratio' => 1
    );

    private function _resize_sticker() {
        list($width, $height) = getimagesize($this->_sticker['path']);
        $this->_sticker['width'] = $width * $this->_sticker['ratio'];
        $this->_sticker['height'] = $height * $this->_sticker['ratio'];

        $new = imagecreatetruecolor($this->_sticker['width'], $this->_sticker['height']);
        imagecopyresampled($new, $this->_sticker['raw'], 0, 0, 0, 0, $this->_sticker['width'], $this->_sticker['height'], $width, $height);

        $this->_sticker['resized'] = $new;
    }

    private function _merge() {
        // Création des instances d'image
        $dest = imagecreatefromgif('php.gif');
        $src = imagecreatefromgif('php.gif');

        // Copie et fusionne
        imagecopymerge($dest, $src, $this->_sticker['x'], $this->_sticker['y'], 0, 0, $this->_sticker['width'], $this->_sticker['height'], 75);

        // Affichage et libération de la mémoire
        header('Content-Type: image/gif');
        imagegif($dest);

        imagedestroy($dest);
        imagedestroy($src);
    }

    public function __construct($base64, $stickerPath, $stickerOpt) {
        // regex_split 'base64,'
        $decode = base64_decode($base64);
        $this->_image = imagecreatefromstring($decode);

        $this->_sticker['path'] = $stickerPath;
        $this->_sticker['raw'] = imagecreatefrompng($stickerPath);
        list($this->_sticker['x'], $this->_sticker['y'], $this->_sticker['ratio']) = $stickerOpt;
        $this->_compute_sticker_size();
    }

    public function __invoke() {

    }
}

 ?>
