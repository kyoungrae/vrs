<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Blade directive for translation
        \Blade::directive('translate', function ($expression) {
            return "<?php echo App\Helpers\TranslationHelper::translate($expression); ?>";
        });
        
        // Blade directive for translation with fallback
        \Blade::directive('translateFallback', function ($expression) {
            $parts = explode(',', $expression, 2);
            $text = trim($parts[0]);
            $fallback = isset($parts[1]) ? trim($parts[1]) : "''";
            return "<?php echo App\Helpers\TranslationHelper::translateWithFallback($text, $fallback); ?>";
        });
    }
    
    public function register()
    {
        //
    }
}
