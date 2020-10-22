<?php

namespace App\Utilities;

use Aws\Exception\AwsException;
use Aws\Ses\SesClient;
use Illuminate\Support\Facades\Mail;

class AwsEmail
{

    public static function send_mail($to = null, $subject = null, $content = null, $cc = null)
    {

        if (is_null($to) || is_null($subject) || is_null($content)) {
            return false;
        }

        $from = config('mail.from.address');
        $from_name = config('mail.from.name');
        $reply_to = config('mail.from.address');

        $char_set = 'UTF-8';
        $source = "{$from_name} <{$from}>";

        $mailParams = [
            'Destination'      => [
                'ToAddresses' => [$to],
                'CcAddresses' => is_null($cc) ? [] : [$cc],
                //'BccAddresses' => is_null($bcc) ? [] : [$bcc],
            ],
            'ReplyToAddresses' => is_null($reply_to) ? [] : [$reply_to],
            'Source'           => $source,
            'Message'          => [
                'Body'    => [
                    'Html' => [
                        'Charset' => $char_set,
                        'Data'    => $content,
                    ],
                    'Text' => [
                        'Charset' => $char_set,
                        'Data'    => strip_tags($content),
                    ],
                ],
                'Subject' => [
                    'Charset' => $char_set,
                    'Data'    => $subject,
                ],
            ],
        ];

        $sdkParams = [
            'region'      => 'eu-west-1',
            'version'     => 'latest',
            'credentials' => [
                'key'    => config('services.ses.key'),
                'secret' => config('services.ses.secret'),
            ]
        ];


        try {

            $SesClient = new SesClient($sdkParams);

            $SesClient->sendEmail($mailParams);

            return true;

        } catch (AwsException $e) {

            //log service
            $logArr = [
                'message' => $e->getMessage(),
                'data'    => $mailParams
            ];

            \Log::error('send_mail', $logArr);

            return $e->getMessage();
        }

    }
}
