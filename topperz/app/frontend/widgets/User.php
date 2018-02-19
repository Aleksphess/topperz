<?php

namespace frontend\widgets;

use Yii;




class User extends \yii\base\Widget
{
    public function run()
    {

        return $this->render('user/view.twig');
    }
}