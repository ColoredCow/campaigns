<?php

namespace App\Helpers;

class ParseEmailTemplate
{
    public static function emailTemplateVariables($user, $emailTemplate)
    {
        $view = $emailTemplate;
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
