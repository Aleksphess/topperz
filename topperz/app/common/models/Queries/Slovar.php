<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\Slovar]].
 *
 * @see \common\models\Slovar
 */
class Slovar extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Slovar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    
    public function byAlias($alias)
    {
        return $this->andWhere(['alias' => $alias]);
    }

    /**
     * @inheritdoc
     * @return \common\models\Slovar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
