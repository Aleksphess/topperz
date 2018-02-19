<?php

namespace common\modules\novaposhta\controllers;

use Yii;
use yii\httpclient\Client;
use common\modules\novaposhta\models\Localities;

/**
 * Description of NovaposhtaController
 *
 * @author kossworth
 */

class NovaposhtaController extends \yii\web\Controller
{
    public function __construct($id, $module, array $config = []) 
    {
//        if(Yii::$app->user->isGuest)
//        {
//            throw new \yii\web\ForbiddenHttpException("Access denied!");
//        }
        parent::__construct($id, $module, $config);
    }
    
    public function actionSaveLocalities() 
    {
        $client = new Client();

        for($i = 0; 1 == 1; $i++)
        {
            $sql = '';
            $response = $client->createRequest()
                ->setMethod('post')
                ->setFormat(Client::FORMAT_JSON)
                ->setUrl('https://api.novaposhta.ua/v2.0/json/')
                ->setData(['modelName' => 'AddressGeneral',
                    'calledMethod' => 'getSettlements',
                    'methodProperties' => ['Page' => $i],
                    'apiKey' => Yii::$app->params['novaPoshtaApiKey']])
                ->send();
            if(!empty($response->data['data']))
            {
                foreach ($response->data['data'] as $locality)
                {
                    $sql .= "INSERT INTO `".Localities::tableName()."` ";
                    $sql .= "(`name_ru`, `name_ua`, `region_name_ru`, `region_name_ua`, `area_name_ru`, `area_name_ua`, `type_ru`, `type_ua`, `latitude`, `longitude`, `creation_time`)";
                    $sql .= " VALUES ";
                    $sql .= "('".addcslashes($locality['DescriptionRu'], "'")."', '".addcslashes($locality['Description'], "'")."', '".addcslashes($locality['RegionsDescriptionRu'], "'")."', '".addcslashes($locality['RegionsDescription'], "'")."', '".addcslashes($locality['AreaDescriptionRu'], "'")."','".addcslashes($locality['AreaDescription'], "'")."','".$locality['SettlementTypeDescriptionRu']."', '".$locality['SettlementTypeDescription']."', '".$locality['Latitude']."', '".$locality['Longitude']."', ".date('U')."); ";
                }

                Yii::$app->db->createCommand($sql)->execute();
            }
            else
            {
                break;
            }
        }
        
    }
    
}