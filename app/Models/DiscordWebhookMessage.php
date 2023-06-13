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
                        "url" => "http://rwhitelist.local/"
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


}
