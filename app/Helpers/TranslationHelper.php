<?php

namespace App\Helpers;

class TranslationHelper
{
    private static $translations = [];

    private static function normalizeText($text)
    {
        if ($text === null) {
            return '';
        }

        if (! is_string($text)) {
            $text = (string) $text;
        }

        $text = trim($text);

        // Strip matching surrounding quotes: "abc" or "abc"
        if (strlen($text) >= 2 && $text[0] === '"' && substr($text, -1) === '"') {
            $text = substr($text, 1, -1);
            $text = trim($text);
        }

        // Best-effort: ensure valid UTF-8 so Blade/HTML escaping doesn't output empty text
        if (function_exists('mb_check_encoding') && ! mb_check_encoding($text, 'UTF-8')) {
            if (function_exists('iconv')) {
                $converted = @iconv('UTF-8', 'UTF-8//IGNORE', $text);
                if ($converted !== false) {
                    $text = $converted;
                }
            }
        }

        return $text;
    }

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

        $text = self::normalizeText($text);
        if ($text === '') {
            return '';
        }

        // Direct translation
        if (isset(self::$translations[$text])) {
            return self::$translations[$text];
        }

        // Try to decode Unicode escape sequences (for JSON data from DB)
        $decodedText = json_decode('"' . $text . '"');
        if ($decodedText !== null && isset(self::$translations[$decodedText])) {
            return self::$translations[$decodedText];
        }

        if ($decodedText !== null) {
            $decodedText = self::normalizeText($decodedText);
            if ($decodedText !== '' && isset(self::$translations[$decodedText])) {
                return self::$translations[$decodedText];
            }
        }

        // Try to decode HTML entities (for HTML content)
        $htmlDecodedText = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        if ($htmlDecodedText !== $text && isset(self::$translations[$htmlDecodedText])) {
            return self::$translations[$htmlDecodedText];
        }

        // Final fallback: return normalized original
        return $text;
    }

    public static function translateWithFallback($text, $fallback = '')
    {
        $translated = self::translate($text);
        return $translated !== $text ? $translated : $fallback;
    }
}