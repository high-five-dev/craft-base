<?php

namespace highfive\base\traits;

use Craft;

trait TranslationTrait
{
    public static function t(string $message, array $params = [], ?string $language = null): string
    {
        $translation = Craft::t(self::getInstance()->handle, $message, $params, $language);

        if ($translation === $message) {
            $translation = Craft::t('app', $message, $params, $language);
        }

        return $translation;
    }
}
