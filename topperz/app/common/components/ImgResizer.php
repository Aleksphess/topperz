<?php

namespace common\components;
use Yii;
use yii\imagine\Image;  
use Imagine\Image\Box;
 
class ImgResizer extends \yii\base\Component 
{
    
    public function resize($path = '', $width = 100, $height = 100)
    {
        Image::thumbnail($path, $width, $height)
                ->resize(new Box(500,300))
                ->save($path, ['quality' => 70]);
//        unlink('../files/upload/' . $image->baseName . '.'  . $image->extension);
    }
    
}