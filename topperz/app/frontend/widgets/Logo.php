<?php

namespace frontend\widgets;

use Yii;
use common\models\Discounts;




class Logo extends \yii\base\Widget
{
    public function run()
    {
        $discount = Discounts::find()->where(['banner'=>1])->orderBy('sort ASC')->limit(1)->one();
       
        //   $advantages=\common\models\Advantages::find()->joinWith('info')->orderBy('sort DESC')->limit(3)->all();
        return $this->render('discount/view.twig',['discount'=>$discount]);
    }
}