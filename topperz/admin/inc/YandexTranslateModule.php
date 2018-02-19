<?php


/**
 * Description of YandexTranslate
 *
 * @author kossworth
 */
class YandexTranslateModule {
        
    /**
     * API key
     * @var string
     */
    public $key;

    /**
     * API URL
     */
    const DETECT_YA_URL = 'https://translate.yandex.net/api/v1.5/tr.json/detect';

    /**
     * API URL
     */
    const TRANSLATE_YA_URL = 'https://translate.yandex.net/api/v1.5/tr.json/translate';

    public function __construct($key) {
        $this->key = $key;
    }
    
    /**
     * Имя класса.
     * @return string наименования класса.
     */
    public static function className()
    {
        return get_called_class();
    }

    public function init()
    {
        parent::init();

        if( empty( $this->key ) )
        {
            throw new InvalidConfigException('Поле <b>$key</b> обязательно к заполнению');
        }
    }

    /** Перевод text/html в $text
     * @param $text Текст для определения языка
     * @return mixed array()
    */
    public function detect($text)
    {
        // this is the form data to be included with the request
        $values = array(
            'key'    => $this->key,
            'text' => $text
        );

        // turn the form data array into raw format so it can be used with cURL
        $formData = http_build_query($values);

        // create a connection to the API endpoint
        $ch = curl_init(self::DETECT_YA_URL);

        // tell cURL to return the response rather than outputting it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // write the form data to the request in the post body
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);

        // include the header to make Google treat this post request as a get request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: GET'));

        // execute the HTTP request
        $json = curl_exec($ch);
        curl_close($ch);

        // decode the response data
        $data = json_decode($json, true);
        return $data;
    }

    /**
     * @param $text Текст, который надо перевести
     * @param $lang Язык, на который надо перевести
     * @return string
     */
    public function translate($text,$lang)
    {
        // this is the form data to be included with the request
        $values = array(
            'key'    => $this->key,
            'text' => $text,
            'lang' => $lang,
            'format' => 'plain',
        );

        // turn the form data array into raw format so it can be used with cURL
        $formData = http_build_query($values);

        // create a connection to the API endpoint
        $ch = curl_init(self::TRANSLATE_YA_URL);

        // tell cURL to return the response rather than outputting it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // write the form data to the request in the post body
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);

        // include the header to make Google treat this post request as a get request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: GET'));

        // execute the HTTP request
        $json = curl_exec($ch);
        curl_close($ch);

        // decode the response data
        $data = json_decode($json, true);
        if($data['code']==200)
        {
            $text = '';
            foreach($data['text'] as $t)
            {
                $text.=$t;
            }
            return $text;
        }
        return $data;
    }
}
