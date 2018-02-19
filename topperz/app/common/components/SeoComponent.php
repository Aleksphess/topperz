<?php

namespace common\components;

use common\models\Lang;
use common\models\Seo;

class SeoComponent
{
    private static $meta = FALSE;

    public static function init()
    {
        if (self::$meta === FALSE)
        {
            //	Массив мета-тегов для страницы
            self::$meta = [
                'title'         => '',
                'description'   => '',
                'h1'            => '',
                'text'          => '',
            ];

            //	Ручные значения тегов из админки
            $url = $_SERVER['REQUEST_URI'];
            $url = preg_replace('#^'.preg_quote(Lang::getCurrentUrl(), '#').'#', '/', $url);
            $static = Seo::find()->innerJoinWith(['info'], true)->andWhere(['url' => $url, 'type' => 'static'])->asArray()->one();
            if ($static && isset($static['info']))
            {
                self::$meta = $static['info'];
            }
            
            //	На всех страницах пейджинга добавляется тег <meta name="robots" content="noindex,nofollow" />
            if ((int)\Yii::$app->getRequest()->get('page') > 1)
            {
                self::$meta['robots'] = 'noindex,nofollow';
            }
        }
    }

    //	Получить текущее значение тега
    public static function get($tag = 'title')
    {
        self::init();
        
        if (isset(self::$meta[$tag]))
        {
            return self::$meta[$tag];
        }

        return NULL;
    }

    //	Установаить значение тега
    public static function set($tag,  $value)
    {
        self::init();

        if (isset(self::$meta[$tag]) && !strlen(trim(self::$meta[$tag])))
        {
            self::$meta[$tag] = $value;
        }
    }

    //	Утсновить значения всех тегов по шаблону
    public static function setByTemplate( $template, array $data)
    {
        self::init();

        $template = Seo::find()->innerJoinWith(['info'], true)->andWhere(['url' => $template, 'type' => 'template'])->asArray()->one();

        if (!is_null($template) && isset($template['info']))
        {
            foreach ($template['info'] as $tag => $value)
            {
                if (is_array($data) && count($data))
                {
                    foreach ($data as $key => $name)
                    {
                        $value = preg_replace('#\{+\s*'.$key.'\s*\}+#', $name, $value);
                    }
                }
                self::set($tag, $value);
            }
        }
    }
}