<?php

namespace frontend\widgets;

use Yii;
use common\models\Lots;
use common\models\Dialogs;


class CabinetMenu extends \yii\base\Widget 
{
    public function run()
    {
        $lots_count = Lots::find()
                ->andWhere(['NOT', ['status_id' => Lots::REMOVED]])
                ->andWhere(['owner_id' => Yii::$app->user->identity->id])
                ->count();
//var_dump(Yii::$app->user->identity->parent_id);
        return $this->render('cabinet/menu.twig', [
            'lots_count'        => $lots_count,
            'msgs_count'        => Dialogs::getUnreadMessagesCount(),
            'current_url'       => Yii::$app->request->url,
			'current_user'		=> Yii::$app->user->identity->parent_id
        ]);
    }
}