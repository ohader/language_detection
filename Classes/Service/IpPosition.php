<?php

declare(strict_types=1);

namespace LD\LanguageDetection\Service;

use Exception;
use Locale;
use ResourceBundle;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Location Service.
 *
 * Get the Location based on the IP.
 * Use the geoplugin.net API.
 */
class IpPosition
{
    public function get(?string $ip = null): ?array
    {
        if (null === $ip) {
            $ip = GeneralUtility::getIndpEnv('REMOTE_ADDR');
        }
        try {
            $urlService = 'http://www.geoplugin.net/php.gp?ip=' . $ip;
            $content = unserialize(GeneralUtility::getUrl($urlService, 0, false));
            if (!\is_array($content) || empty($content) || '404' === $content['geoplugin_status']) {
                throw new Exception('Missing information in response', 123781);
            }

            return $content;
        } catch (Exception $exc) {
            return null;
        }
    }

    public function getLanguage(?string $ip = null): ?string
    {
        $data = $this->get($ip);
        if (null !== $data && !isset($data['geoplugin_countryCode'])) {
            return null;
        }

        return (string)$this->mapCountryToLanguage($data['geoplugin_countryCode']);
    }

    protected function mapCountryToLanguage(string $country): string
    {
        $subtags = ResourceBundle::create('likelySubtags', 'ICUDATA', false);
        $country = Locale::canonicalize('und_' . $country);
        $locale = $subtags->get($country) ?: $subtags->get('und');

        return Locale::getPrimaryLanguage($locale);
    }
}
