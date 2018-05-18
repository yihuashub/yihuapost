<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 11/9/2017
 * Time: 9:58 PM
 */
session_start();

if (isset($_SESSION['language']) && !empty($_SESSION['language'])) {
    if (isset($_GET["hl"])) {
        $_SESSION["language"] = $_GET["hl"];
    }
} else {

    if (strpos($_SERVER['SERVER_NAME'], 'dichanjingji.com') == true) {
        $lang = "zh";
        $_SESSION["language"] = $lang;
    }else{
        $lang = "en";
        $_SESSION["language"] = $lang;
    }
}

/*else {
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    switch ($lang) {
        case "zh":
            $_SESSION["language"] = $lang;
            break;
        case "en":
            $_SESSION["language"] = $lang;
            break;
        default:
            $lang = "en";
            $_SESSION["language"] = $lang;
            break;
    }
}
*/


$siteLanguage = $_SESSION["language"];


function getVailableLanguage()
{
    $language = array(
        'af' => 'Afrikaans',
        'az' => 'Azerbaijani',
        'eu' => 'Basque',
        'be' => 'Belarusian',
        'be-lat' => 'Belarusian latin',
        'bg' => 'Bulgarian',
        'bs' => 'Bosnian',
        'ca' => 'Catalan',
        'zh' => 'Chinese',
        //'zh-TW'     => 'Chinese traditional',
        //'zh-CN'     => 'Chinese simplified',
        'cs' => 'Czech',
        'da' => 'Danish',
        'de' => 'German',
        'el' => 'Greek',
        'en' => 'English',
        'es' => 'Spanish',
        'et' => 'Estonian',
        'fa' => 'Persian',
        'fi' => 'Finnish',
        'fr' => 'French',
        'gl' => 'Galician',
        'he' => 'Hebrew',
        'hi' => 'Hindi',
        'hr' => 'Croatian',
        'hu' => 'Hungarian',
        'id' => 'Indonesian',
        'it' => 'Italian',
        'ja' => 'Japanese',
        'ko' => 'Korean',
        'ka' => 'Georgian',
        'lt' => 'Lithuanian',
        'lv' => 'Latvian',
        'mk' => 'Macedonian',
        'mn' => 'Mongolian',
        'ms' => 'Malay',
        'nl' => 'Dutch',
        'no' => 'Norwegian',
        'pl' => 'Polish',
        'pt-BR' => 'Brazilian portuguese',
        'pt' => 'Portuguese',
        'ro' => 'Romanian',
        'ru' => 'Russian',
        'si' => 'Sinhala',
        'sk' => 'Slovak',
        'sl' => 'Slovenian',
        'sq' => 'Albanian',
        'sr-lat' => 'Serbian latin',
        'sr' => 'Serbian',
        'sv' => 'Swedish',
        'th' => 'Thai',
        'tr' => 'Turkish',
        'tt' => 'Tatarish',
        'uk' => 'Ukrainian',
    );
    return $language;
}

function getLanguageName($language)
{
    $languages = getVailableLanguage();
    return $languages[$language];
}

$language_name = getLanguageName($_SESSION["language"]);

if($language_name != null)
{
    require("system_files/lang/" . $language_name . ".php");
}
else
{
    echo "System Error: Missing Language file.";
}

