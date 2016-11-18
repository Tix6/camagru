<?php

final class ImageMerged {

    const IMAGE_DIR = 'data/images/';
    private $_image;
    private $_sticker = array(
        'path' => '',
        'width' => 0,
        'height' => 0,
        'new_width' => 0,
        'new_height' => 0,
        'x' => 0,
        'y' => 0,
        'ratio' => 1,
        'alpha' => 100,
        'quality' => 9
    );
    private $_pathname = '';

    private function _enable_alpha($img) {
        imagealphablending($img, false);
        imagesavealpha($img, true);
    }

    private function _compute_sticker_size() {
        list($width, $height) = getimagesize($this->_sticker['path']);
        $this->_sticker['width'] = $width;
        $this->_sticker['height'] = $height;
        $this->_sticker['new_width'] = $width * $this->_sticker['ratio'];
        $this->_sticker['new_height'] = $height * $this->_sticker['ratio'];
    }

    private function _resize_sticker() {
        $new = imagecreatetruecolor($this->_sticker['new_width'], $this->_sticker['new_height']);
        $this->_enable_alpha($new);
        imagecopyresampled(
            $new,
            $this->_sticker['raw'],
            0, 0, 0, 0,
            $this->_sticker['new_width'],
            $this->_sticker['new_height'],
            $this->_sticker['width'],
            $this->_sticker['height']
        );
        $this->_sticker['resized'] = $new;
    }

    private function _imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct) {
        $cut = imagecreatetruecolor($src_w, $src_h);
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
        imagedestroy($cut);
    }

    private function _merge() {
        $this->_enable_alpha($this->_image);
        $this->_imagecopymerge_alpha(
            $this->_image,
            $this->_sticker['resized'],
            $this->_sticker['x'],
            $this->_sticker['y'],
            0,
            0,
            $this->_sticker['new_width'],
            $this->_sticker['new_height'],
            $this->_sticker['alpha']
        );
    }

    private function _init_pathname() {
        /* random_bytes php 7 only */
        $this->_pathname = self::IMAGE_DIR . bin2hex(random_bytes(8)) . '.png';
    }

    private function _save() {
        imagepng($this->_image, $this->_pathname, $this->stickerOpt['quality']);
    }

    private function _free() {
        imagedestroy($this->_image);
        imagedestroy($this->_sticker['raw']);
        imagedestroy($this->_sticker['resized']);
    }

    public function __construct($base64, $stickerPath, $stickerOpt) {
        $base64 = preg_replace('/^data:image\/png;base64,/', '', $base64, 1);

        $decode = base64_decode($base64);
        $this->_image = imagecreatefromstring($decode);

        $this->_sticker['path'] = $stickerPath;
        $this->_sticker['raw'] = imagecreatefrompng($stickerPath);
        $this->_enable_alpha($this->_sticker['raw']);

        $this->_sticker['x'] = $stickerOpt['x'];
        $this->_sticker['y'] = $stickerOpt['y'];
        $this->_sticker['ratio'] = $stickerOpt['ratio'];
    }

    public function __invoke() {
        $this->_compute_sticker_size();
        $this->_resize_sticker();
        $this->_merge();
        $this->_init_pathname();
        $this->_save();
        $this->_free();
        print_r($this->_sticker);
        return $this->_pathname;
    }
}

?>
