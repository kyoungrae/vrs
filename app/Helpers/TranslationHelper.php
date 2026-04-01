<?php

namespace App\Helpers;

class TranslationHelper
{
    private static $translations = [];
    
    public static function loadTranslations()
    {
        if (empty(self::$translations)) {
            $translationsFile = __DIR__ . '/../../scripts/mn_ko_pairs.tsv';
            
            // Debug: Check if file exists
            if (!file_exists($translationsFile)) {
                error_log("Translation file not found: " . $translationsFile);
                return;
            }
            
            $lines = file($translationsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '#') === 0 || strpos($line, "\t") === false) {
                    continue; // Skip comments and invalid lines
                }
                list($mongolian, $korean) = explode("\t", $line, 2);
                $mongolian = trim($mongolian);
                $korean = trim($korean);
                self::$translations[$mongolian] = $korean;
                
                // Debug: Log specific translation
                if ($mongolian === 'Цагаан') {
                    error_log("Found translation: Цагаан -> " . $korean);
                }
            }
            
            // Debug: Log total translations loaded
            error_log("Total translations loaded: " . count(self::$translations));
        }
    }
    
    public static function translate($text)
    {
        self::loadTranslations();
        
        // Direct translation
        if (isset(self::$translations[$text])) {
            return self::$translations[$text];
        }
        
        // Try to decode Unicode escape sequences
        $decodedText = json_decode('"' . $text . '"');
        if ($decodedText !== null && isset(self::$translations[$decodedText])) {
            return self::$translations[$decodedText];
        }
        
        // Return original if no translation found
        return $text;
    }
    
    public static function translateWithFallback($text, $fallback = '')
    {
        $translated = self::translate($text);
        return $translated !== $text ? $translated : $fallback;
    }
}
