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
    public function SendWebhookRecruitementSession(){
        $timestamp = date("c", strtotime("now"));
        $msg = json_encode([
            // Username
            "username" => "Recrutement",
            // text-to-speech
            "tts" => false,
            // Embeds Array
            "embeds" => [
                [
                    // Title
                    "title" => "Nouvelle session de recrutement",
                    // Embed Type, do not change.
                    "type" => "rich",
                    // Description
                    "description" => "Vous trouverez sur le panel une nouvelle session de recrutement, pour vous y rendre aller sur votre compte dans l'option Session, vous pourrez vous inscrire",

                    // Link in title
                    "url" => "http://rwhitelist.local/sessions",

                    // Timestamp, only ISO8601
                    "timestamp" => $timestamp,

                    // Left border color, in HEX
                    "color" => hexdec( "3366ff" ),

                    // Footer text
                    "footer" => [
                        "text" => "Reyzan",
                    ],

                    // Author name & url
                    "author" => [
                        "name" => "Classic Roleplay",
                        "url" => "http://rwhitelist.local/sessions"
                    ],

                    // Custom fields
                    "fields" => [
                        // Field 1
                        [
                            "name" => "Date de la Session",
                            "value" => "12/04/2023 - 14:52",
                            "inline" => true
                        ],
                        // Field 2
                        [
                            "name" => "Nombre de places",
                            "value" => "12 places",
                            "inline" => true
                        ],
                        [
                            "name" => "Lien d'inscription",
                            "value" => "https://classicrp.fr",
                            "url" => "https://classicrp.fr",
                            "inline" => false
                        ]
                        // etc
                    ]
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


        $ch = curl_init($this->_Url);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $msg);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec($ch);
        curl_close($ch);
    }


}
