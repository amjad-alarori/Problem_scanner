<?php

namespace App\Mail\Mails;

use App\Helpers\EmailHelper;
use App\Helpers\LanguageHelper;
use App\Models\EmailTranslation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable as VendorMailable;
use Illuminate\Queue\SerializesModels;

class Mailable extends VendorMailable
{
    use Queueable, SerializesModels;

    protected string $language;
    public string $body;
    public array $variables;
    public string $calledClass;

    public function __construct($language = null)
    {
        $this->calledClass = substr(get_called_class(), strrpos(get_called_class(), '\\') + 1);
        $this->language = $language ?? LanguageHelper::$DEFAULT_LANGUAGE;
    }

    public function build()
    {
        $template = EmailHelper::GetEmailTranslation($this->calledClass, $this->language);
        $this->subject = $this->buildWithVariables($template->subject);
        $this->body = $this->buildWithVariables($template->body);
        return $this->view('mails.mail');
    }

    public function buildWithVariables($text)
    {
        preg_match_all('/%(.*?)%/', $text, $output_msg);
        foreach ($output_msg[0] as $key => $part) {
            $replacekey = strtoupper($output_msg[1][$key]);
            if (isset($this->variables[$replacekey]) && !empty($this->variables[$replacekey])) {
                $text = str_replace($part, $this->variables[$replacekey], $text);
            }
        }
        return $text;
    }

    public function setVariables($variables)
    {
        $this->variables = $variables;
    }

    public function getVariables()
    {
        return $this->variables;
    }

}
