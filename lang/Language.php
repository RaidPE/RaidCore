<?php

namespace Raid\lang;

use Raid\Core;

class Language
{
    public const FALLBACK_LANGUAGE = "eng";

    private $lang = [];

    public function __construct(string $path)
    {
        foreach(['eng'] as $lang)
        {
            $this->lang[$lang] = [];
            self::loadLang($path . $lang . '.ini', $this->lang[$lang]);
        }
    }

    public function getLang(string $lang = self::FALLBACK_LANGUAGE) : array
    {
        return $this->lang[$lang] ?? null;
    }

    public function internalGet(string $id, string $lang = self::FALLBACK_LANGUAGE)
    {
        return $this->lang[$lang][$id] ?? null;
    }

    // Code from PocketMine-MP

    protected function parseTranslation(string $text, string $lang = self::FALLBACK_LANGUAGE, string $onlyPrefix = null) : string
    {
        $newString = "";

        $replaceString = null;

        $len = strlen($text);
        for($i = 0; $i < $len; ++$i){
            $c = $text{$i};
            if($replaceString !== null){
                $ord = ord($c);
                if(
                    ($ord >= 0x30 and $ord <= 0x39) // 0-9
                    or ($ord >= 0x41 and $ord <= 0x5a) // A-Z
                    or ($ord >= 0x61 and $ord <= 0x7a) or // a-z
                    $c === "." or $c === "-"
                ){
                    $replaceString .= $c;
                }else{
                    if(($t = $this->internalGet(substr($replaceString, 1), $lang)) !== null and ($onlyPrefix === null or strpos($replaceString, $onlyPrefix) === 1)){
                        $newString .= $t;
                    }else{
                        $newString .= $replaceString;
                    }
                    $replaceString = null;

                    if($c === "%"){
                        $replaceString = $c;
                    }else{
                        $newString .= $c;
                    }
                }
            }elseif($c === "%"){
                $replaceString = $c;
            }else{
                $newString .= $c;
            }
        }

        if($replaceString !== null){
            if(($t = $this->internalGet(substr($replaceString, 1), $lang)) !== null and ($onlyPrefix === null or strpos($replaceString, $onlyPrefix) === 1)){
                $newString .= $t;
            }else{
                $newString .= $replaceString;
            }
        }

        return $newString;
    }

    public function translate(TextContainer $c, string $lang = self::FALLBACK_LANGUAGE)
    {
        if($c instanceof TranslationContainer){
            $baseText = $this->internalGet($c->getText(), $lang);
            $baseText = $this->parseTranslation($baseText ?? $c->getText(), $lang);

            foreach($c->getParameters() as $i => $p){
                $baseText = str_replace("{%$i}", $this->parseTranslation($p), $baseText);
            }
        }else{
            $baseText = $this->parseTranslation($c->getText(), $lang);
        }

        return $baseText;
    }

    private static function loadLang(string $path, array &$d)
    {
        if(file_exists($path))
            $d = array_map('stripcslashes', parse_ini_file($path, false, INI_SCANNER_RAW));
        else
            Core::getInstance()->getLogger()->error("Missing required language file $path");
    }
}