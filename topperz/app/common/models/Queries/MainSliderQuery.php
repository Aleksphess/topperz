<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\MainSlider]].
 *
 * @see \common\models\MainSlider
 */
class MainSliderQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\MainSlider[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\MainSlider|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
