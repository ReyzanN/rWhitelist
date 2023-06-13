<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscordWebhookMessage
{
    use tools;

    /*
     * Attributes
     */
    private string $_Url;

    public function __construct(string $Url){
        $this->_Url = $Url;
    }

    /*
     * Functions
     */
    public function SendWebhookRecruitementSession($SessionDate,$maxCandidate,$Theme,$Creator){
        $TimeStamps = date("c", strtotime("now"));
        $MessageContent = json_encode([
            "username" => "Recrutement",
            "tts" => false,
            "embeds" => [
                [
                    "title" => "Nouvelle session de recrutement",
                    "type" => "rich",
                    "description" => "Vous trouverez sur le panel une nouvelle session de recrutement, pour vous y rendre aller sur votre compte dans l'option Session, vous pourrez vous inscrire",
                    "url" => "http://rwhitelist.local/sessions",
                    "timestamp" => $TimeStamps,
                    "color" => hexdec( "b56690"),
                    "footer" => [
                        "text" => $Creator,
                    ],
                    "author" => [
                        "name" => "Classic Roleplay",
                        "url" => env('APP_URL')
                    ],
                    "fields" => [
                        [
                            "name" => "Date de la Session",
                            "value" => $SessionDate,
                            "inline" => true
                        ],
                        [
                            "name" => "Nombre de places",
                            "value" => "$maxCandidate places",
                            "inline" => true
                        ],
                        [
                            "name" => "Thème de la session",
                            "value" => $Theme,
                            "inline" => true
                        ],
                        [
                            "name" => "Lien d'inscription",
                            "value" => "http://rwhitelist.local/session",
                            "url" => "http://rwhitelist.local/session",
                            "inline" => false
                        ]
                    ]
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        $Curl = curl_init($this->_Url);
        curl_setopt($Curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($Curl, CURLOPT_POST, 1);
        curl_setopt($Curl, CURLOPT_POSTFIELDS, $MessageContent);
        curl_setopt($Curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($Curl, CURLOPT_HEADER, 0);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec($Curl);
        curl_close($Curl);
    }

    public function SendWebhookCallCandidate($DiscordCandidate){
        $MessageContent = json_encode([
            "username" => "Recrutement",
            "tts" => false,
            "content" => "Bonjour, <@$DiscordCandidate>, merci de te présenter !"
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        $Curl = curl_init($this->_Url);
        curl_setopt($Curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($Curl, CURLOPT_POST, 1);
        curl_setopt($Curl, CURLOPT_POSTFIELDS, $MessageContent);
        curl_setopt($Curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($Curl, CURLOPT_HEADER, 0);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec($Curl);
        curl_close($Curl);
    }

    public function SendWebhookCallCandidateAll(array $DiscordAccountList){
        $Content = "Bonjour, ";
        foreach ($DiscordAccountList as $Account){
            $Content .= "<@$Account>,";
        }
        $Content .= "la session, va débuter merci de vous rendre disponniblent";
        $MessageContent = json_encode([
            "username" => "Recrutement",
            "tts" => false,
            "content" => $Content
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        $Curl = curl_init($this->_Url);
        curl_setopt($Curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($Curl, CURLOPT_POST, 1);
        curl_setopt($Curl, CURLOPT_POSTFIELDS, $MessageContent);
        curl_setopt($Curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($Curl, CURLOPT_HEADER, 0);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec($Curl);
        curl_close($Curl);
    }

    public function SendRecapSession($SessionId,$SessionDate,$SessionCandidate,$SessionCandidateCount,$SessionMaxCandidate,$Creator,$SessionTheme,$FieldList){
        $TimeStamps = date("c", strtotime("now"));
        $MessageContent = json_encode([
            "username" => "Oggy Les Bon Tuyaux",
            "tts" => false,
            "embeds" => [
                [
                    "title" => "Récapitulatif",
                    "type" => "rich",
                    "description" => "Récapitulatif de la session de recrutement N°$SessionId",
                    "timestamp" => $TimeStamps,
                    "color" => hexdec( "b56690"),
                    "footer" => [
                        "text" => "$Creator",
                    ],
                    "author" => [
                        "name" => "Classic Roleplay",
                        "url" => env('APP_URL')
                    ],
                    "fields" => $FieldList
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        $Curl = curl_init($this->_Url);
        curl_setopt($Curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($Curl, CURLOPT_POST, 1);
        curl_setopt($Curl, CURLOPT_POSTFIELDS, $MessageContent);
        curl_setopt($Curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($Curl, CURLOPT_HEADER, 0);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec($Curl);
        curl_close($Curl);
        dd($MessageContent);
    }


}
