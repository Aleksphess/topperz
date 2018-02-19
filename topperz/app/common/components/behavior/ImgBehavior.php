<?php

namespace common\components\behavior;

use yii\helpers\Url;

/**
 * Description of ImgBehavior
 *
 * @author kossworth
 */
class ImgBehavior extends \yii\base\Behavior {
    
    /**
    * Get image path
    */    
    public function getImgPath()
    {
        $table_name=$this->owner->tableName();
        $path = __DIR__ . "/../../../../images/$table_name/{$this->owner->id}.1.b.jpg";
        if(file_exists($path)) 
        {
            return $path;
        } 
        else 
        {
            return false;
        }
    }
    
    //
    //big images urls array
    //
    public function getImgs() {
        $i = 1;
        $res = [];
        $table_name = $this->owner->tableName();
        while($i <= $this->owner->img_count_const()){
            if(is_file(__DIR__ . '/../../../../images/'. $table_name.'/'.$this->owner->id.".$i.b.jpg"))
            {
                $res[] =[
                    'bimg'  =>   '/images/'. $table_name.'/'.$this->owner->id.".$i.b.jpg",
                    'simg'  =>   '/images/'. $table_name.'/'.$this->owner->id.".$i.s.jpg"
                ];
          //      $res['simg'] =  ;
            }
            elseif($i == 1)
            {
                $res[] =[
                    'bimg'  =>   '/images/no-img.png',
                    'simg'  =>   '/images/no-img.png'
                ];
            }
            $i++;
        }
    //    var_dump($res);die();
        return $res;
    }
    public function getBImgs() {
        $i = 1;
        $res = [];
        $table_name = $this->owner->tableName();
        while($i <= $this->owner->img_count_const()){
            if(is_file(__DIR__ . '/../../../../images/'. $table_name.'/'.$this->owner->id.".$i.b.jpg"))
            {
                $res[] =  '/images/'. $table_name.'/'.$this->owner->id.".$i.b.jpg";
            }
            elseif (is_file(__DIR__ . '/../../../../images/'. $table_name.'/'.$this->owner->id.".$i.b.png"))
            {
                $res[] =  '/images/'. $table_name.'/'.$this->owner->id.".$i.b.png";
            }
            elseif($i == 1) 
            {
                $res[] = '/images/no-img.png';
            }
            $i++;
        }
        return $res;
    }
    
    //
    //small images urls array
    //
    public function getSImgs() {
        $i = 1;
        $res = [];
        $table_name = $this->owner->tableName();
        while($i <= $this->owner->img_count_const()){
            if(is_file(__DIR__ . '/../../../../images/'. $table_name.'/'.$this->owner->id.".$i.s.jpg"))
            {
                $res[] =  '/images/'. $table_name.'/'.$this->owner->id.".$i.s.jpg";
            }
            elseif (is_file(__DIR__ . '/../../../../images/'. $table_name.'/'.$this->owner->id.".$i.s.png"))
            {
                $res[] =  '/images/'. $table_name.'/'.$this->owner->id.".$i.s.png";
            }
            elseif($i == 1) 
            {
                $res[] =  '/images/no-img.png';
            }
            $i++;
        }
        return $res;
    }
    //
    //small first image url
    //
    public function getSImg() 
    {   
        $table_name = $this->owner->tableName();
        if(is_file(__DIR__ . '/../../../../images/'. $table_name.'/'.$this->owner->id.".1.s.jpg"))
        {
            return '/images/'.$table_name.'/'.$this->owner->id.".1.s.jpg";
        }
        elseif (is_file(__DIR__ . '/../../../../images/'. $table_name.'/'.$this->owner->id.".1.s.png"))
        {
            return '/images/'.$table_name.'/'.$this->owner->id.".1.s.png";
        }
        else
        {
            return '/images/no-img.png';
        }    
    }
    
    public function getBImg() 
    {   
        $table_name = $this->owner->tableName();
        if(is_file(__DIR__ . '/../../../../images/'. $table_name.'/'.$this->owner->id.".1.b.jpg"))
        {
//            return Url::to(['/images/'.$table_name.'/'.$this->owner->id.".1.b.jpg"]) ;
            return '/images/'.$table_name.'/'.$this->owner->id.".1.b.jpg";
        }
        elseif (is_file(__DIR__ . '/../../../../images/'. $table_name.'/'.$this->owner->id.".1.b.png"))
        {
//            return Url::to(['/images/'.$table_name.'/'.$this->owner->id.".1.b.jpg"]) ;
            return '/images/'.$table_name.'/'.$this->owner->id.".1.b.png";
        }
        else
        {

            return ($table_name=='catalog_consist')  ? '/images/not_found.png' : '/images/no-img.png';
        }   
    }
}