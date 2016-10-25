<?php
/**
 * Author: Salikh Gurgenidze
 * Nickname: Vati Child
 * Git: https://github.com/Vatia13
 * Description: Image Watermark Class
 */

class Watermark{

    public $merge_right = 10;

    public $merge_bottom = 10;

    public $font;

    public $font_size;

    public $image;

    public $watermark;

    private $image_info;

    private $watermark_info;

    private $extension;

    private $new_image;

    private $stamp;

    private $allow_ext = array('jpeg','png','gif');


    public function create($image,$watermark){
        $this->image = $image;
        $this->image_info = getimagesize($this->image);
        $this->watermark = $watermark;
        if(file_exists($this->watermark)){
            $this->watermark_info = getimagesize($this->watermark);
        }
    }


    private function imgExt(){
        $this->extension = str_replace('image/','',$this->image_info['mime']);
        if(!in_array($this->extension,$this->allow_ext)){
            return false;
        }else{
            return $this->extension;
        }
    }

    private function wmExt(){
        $this->extension = str_replace('image/','',$this->watermark_info['mime']);
        if(!in_array($this->extension,$this->allow_ext)){
            return false;
        }else{
            return $this->extension;
        }
    }

    private function createImage($image,$ext){
        switch($ext){
            case $this->allow_ext[1]:
                return imagecreatefrompng($image);
                break;
            case $this->allow_ext[2]:
                return imagecreatefromgif($image);
                break;
            default:
                return imagecreatefromjpeg($image);
                break;
        }
    }

    public function save()
    {

        $this->new_image = $this->createImage($this->image, $this->imgExt());
        if(file_exists($this->watermark)){
            $this->stamp = $this->createImage($this->watermark, $this->wmExt());
            $sx = imagesx($this->stamp);
            $sy = imagesy($this->stamp);

            imagecopymerge($this->new_image, $this->stamp, imagesx($this->new_image) - $sx - $this->merge_right, imagesy($this->new_image) - $sy - $this->merge_bottom, 0, 0, imagesx($this->stamp), imagesy($this->stamp), 50);

        }else{
            $white = imagecolorallocate($this->new_image, 255, 255, 255);
            $sx = strlen($this->watermark) * $this->font_size;
            $sy = $this->font_size;
            imagettftext($this->new_image, $this->font_size, 0, imagesx($this->new_image) - $sx - $this->merge_right, imagesy($this->new_image) - $sy - $this->merge_bottom, $white, $this->font, $this->watermark);
        }


        imagejpeg($this->new_image, $this->image);
        imagedestroy($this->new_image);

    }

}
?>