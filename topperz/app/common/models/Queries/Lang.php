<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\Lang]].
 *
 * @see \common\models\Lang
 */
class Lang extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Lang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Lang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getDefault()
    {
        return parent::where('`by_default` = :default', [':default' => 1])->one();
    }

    /**
     * @inheritdoc
     * @param $url
     * @return array|null|\yii\db\ActiveRecord
     */
    public function byUrl($url)
    {
        return parent::where('url = :url', [':url' => $url])->one();
    }

    public function allWithoutCurrent($current_id)
    {
        return parent::where('id != :current_id', [':current_id' => $current_id])->all();
    }
}

