<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\Menu]].
 *
 * @see \common\models\Menu
 */
class MenuQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Menu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Menu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function top()
    {
        return $this->andWhere(['top_menu'=>1]);
    }
    public function bottom()
    {
        return $this->andWhere(['buttom_menu'=>1]);
    }
    public function inMenu()
    {
        return $this->andWhere(['in_menu_menu'=>1]);
    }
    public function noMenu()
    {
        return $this->andWhere(['in_menu_menu'=>0]);
    }
}
