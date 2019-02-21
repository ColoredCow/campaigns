<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Crypt;

class EmailTemplate
{
    public static function parseEmailTemplateVariables($user, $emailTemplate)
    {
        $view = \View::make('emails.plain', ['mailBody' => $emailTemplate, 'encryptedSubscriberId' => Crypt::encrypt($user->id)])->render();
        foreach (config('constants.email_template_variables') as $variable) {
            switch ($variable) {
                case 'USERNAME':
                    $view = str_replace("|*$variable*|", $user->name, $view);
                    break;
            }
        }
        return $view;
    }
}
