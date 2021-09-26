<?php

declare(strict_types=1);

namespace LD\LanguageDetection\Service;

class Normalizer
{
    public function normalizeList(array $locales): array
    {
        return array_map(function (string $locale): string {
            return $this->normalize($locale);
        }, $locales);
    }

    public function normalize(string $locale): string
    {
        // Drop charset
        $pos = strpos($locale, '.');
        if (false !== $pos) {
            $locale = substr($locale, 0, $pos);
        }

        $code = str_replace('-', '_', $locale);
        $parts = explode('_', $code);

        $locale = strtolower($parts[0]);
        if (isset($parts[1])) {
            $locale .= '_' . strtoupper($parts[1]);
        }

        return $locale;
    }
}
