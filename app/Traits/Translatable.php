<?php

namespace App\Traits;

trait Translatable
{
    /**
     * Get attribute with automatic translation
     */
    public function getTranslatedAttribute($key)
    {
        $value = $this->getAttribute($key);
        
        if ($value && is_string($value)) {
            return \App\Helpers\TranslationHelper::translate($value);
        }
        
        return $value;
    }
    
    /**
     * Get all attributes with translation
     */
    public function getTranslatedAttributes()
    {
        $attributes = $this->getAttributes();
        $translated = [];
        
        foreach ($attributes as $key => $value) {
            if (is_string($value)) {
                $translated[$key] = \App\Helpers\TranslationHelper::translate($value);
            } else {
                $translated[$key] = $value;
            }
        }
        
        return $translated;
    }
    
    /**
     * Magic method for automatic translation
     */
    public function __get($key)
    {
        $value = parent::__get($key);
        
        // Only translate string values and skip system attributes
        if ($value && is_string($value) && 
            !in_array($key, ['id', 'created_at', 'updated_at', 'deleted_at']) &&
            !str_starts_with($key, '_')) {
            return \App\Helpers\TranslationHelper::translate($value);
        }
        
        return $value;
    }
}
