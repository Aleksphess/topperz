<?php

namespace frontend\widgets;

use Yii;
use common\models\Menu;



class HeadMenu extends \yii\base\Widget
{
    public $mobile = false;

    public function run()
    {
        $menu = Menu::find()->top()->joinWith('info')
            ->all();
        if($this->mobile)
        {
            return $this->render('head/mobile.twig', [
                'menu'        => $menu,
            ]);
        }
        else
        {
            return $this->render('head/menu.twig', [
                'menu'        => $menu,
            ]);
        }

    }
}