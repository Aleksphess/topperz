<?php 

namespace common\components;

use Yii;
use common\models\EmailTemplates;

class MailComponent
{
    //  create view for email letter  
    public static function view_include($fileName, $vars = array()) {
	// Устанавливаем переменные
	foreach($vars as $key => $value)
		$$key = $value;

	// Генерация HTML в строку.
	ob_start();
	include $fileName;
	return ob_get_clean();	
    }
    
    private static function generateBody($template = null, $data)
    {
        if(is_array($data) && !empty($data))
        {
            foreach($data as $key => $value)
            {
                $body = str_replace('{'.$key.'}', $value, $template);
            }
            return $body;
        }
        return false;
    }
    
    public static function mailsend($data, $mail_template, $to = null, $subject = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $template = EmailTemplates::find()->where([EmailTemplates::tableName().'.alias' => $mail_template])->limit(1)->one();
        if(!is_object($template))
        {
            return 'Unknown template: '.$mail_template;
        }
        
        $body = self::generateBody($template->text, $data);
        if(is_null($subject) || empty($subject))
        {
            $subject = $template->subject;
        }
        
        if(empty($to))
        {
            $to = $template->send_to;
        }
        
        if(!empty($body)){
            $message = Yii::$app->mailer->compose()
                ->setFrom('noreply@kossworth.com')
                ->setTo([$to])
                ->setSubject($subject)
                ->setTextBody($body)
                ->send();

            if($message):
                return ['response' => 'good', 'message' => $message];
            else:
                return ['response' => 'bad', 'message' => $message];
            endif;

        } else {
            return ['response' => 'bad', 'message' => 'data is empty!'];
        }
    }
    
    public static function unisenderMailsend($template_name = '', $email_to = '', $subject = null, $data = [])
    {
        $api_key    = Yii::$app->params['unisenderApiKey'];
		
        $template = EmailTemplates::find()->where([EmailTemplates::tableName().'.alias' => $template_name])->limit(1)->one();
        if(is_null($template))
        {
            return 'Unknown template: '.$template_name;
        }
        
        $body = $template->body_1;
        if(is_array($data) && !empty($data))
        {
            foreach($data as $key => $value)
            {
                $body = str_replace('{'.$key.'}', $value, $body);
            }
        }
        
        if(is_null($subject) || empty($subject))
        {
            $subject = $template->theme_1;
        }
      
        /*
         *Preparing email for sending by Unisender sendEmail method
         */
        $email_from_name        = 'name';
        $email_from_email       = 'some@email.com';
        $list_id                = 1234567;
        
        $request = [
           'api_key'               => $api_key,
           'email'                 => $email_to,
           'sender_name'           => $email_from_name,
           'sender_email'          => $email_from_email,
           'subject'               => $subject,
           'body'                  => $body,
           'list_id'               => $list_id
        ];
        
        // проверяем, если пришло несколько емейлов (перечисленных через запятую)
        // тогда отдельно генерим параметры для UniSender
        if(mb_stripos($email_to, ',')) {
            $emails = explode(',', $email_to);
            foreach ($emails as $key => $email)
            {
                $request['email['.$key.']'] = $email;
            }
        } else {
            $request['email'] = $email_to;
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_URL, 'https://api.unisender.com/ru/api/sendEmail?format=json');
        $result = curl_exec($ch);

        if ($result)
        {
            $jsonObj = json_decode($result);
                        
            if (null === $jsonObj)
            {
                return 'Invalid JSON';
            }
            elseif (!empty($jsonObj->error))
            {
                return sprintf('An error occured %s (code: %s)', $jsonObj->error, $jsonObj->code);
            }
            else
            {
//                return 'Email message is sent. Message id ' . $jsonObj->result->email_id;
                return 'Email message is sent.';
            }
        }
        else
        { 
            return 'API access error';
        }
    }

}