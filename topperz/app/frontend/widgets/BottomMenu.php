<?php

namespace frontend\widgets;

use Yii;
use common\models\Menu;



class BottomMenu extends \yii\base\Widget
{
    public $menu_bottom = false;

    public function run()
    {


        if($this->menu_bottom)
        {
            $menu = Menu::find()->bottom()->noMenu()->joinWith('info')
                ->all();
            return $this->render('bottom/no_menu.twig', [
                'menu'        => $menu,
            ]);
        }
        else
        {
            $menu = Menu::find()->bottom()->inMenu()->joinWith('info')
                ->all();
            return $this->render('bottom/menu.twig', [
                'menu'        => $menu,
            ]);
        }

    }
}