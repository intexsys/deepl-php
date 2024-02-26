<?php

// Copyright 2022 DeepL SE (https://www.deepl.com)
// Use of this source code is governed by an MIT
// license that can be found in the LICENSE file.

namespace DeepL;

/**
 * Language codes for the languages currently supported by DeepL translation. New languages may be added in the future;
 * to retrieve the currently supported languages use the getSourceLanguages() and getSourceLanguages() functions.
 * @see Translator::getSourceLanguages()
 * @see Translator::getTargetLanguages()
 */
final class LanguageCode
{
    /** Bulgarian language code, may be used as source or target language. */
    const BULGARIAN = 'bg';

    /** Czech language code, may be used as source or target language. */
    const CZECH = 'cs';

    /** Danish language code, may be used as source or target language. */
    const DANISH = 'da';

    /** German language code, may be used as source or target language. */
    const GERMAN = 'de';

    /** Greek language code, may be used as source or target language. */
    const GREEK = 'el';

    /** English language code, may only be used as a source language. */
    const ENGLISH = 'en';

    /** British English language code, may only be used as a target language. */
    const ENGLISH_BRITISH = 'en-GB';

    /** American English language code, may only be used as a target language. */
    const ENGLISH_AMERICAN = 'en-US';

    /** Spanish language code, may be used as source or target language. */
    const SPANISH = 'es';

    /** Estonian language code, may be used as source or target language. */
    const ESTONIAN = 'et';

    /** Finnish language code, may be used as source or target language. */
    const FINNISH = 'fi';

    /** French language code, may be used as source or target language. */
    const FRENCH = 'fr';

    /** Hungarian language code, may be used as source or target language. */
    const HUNGARIAN = 'hu';

    /** Italian language code, may be used as source or target language. */
    const ITALIAN = 'it';

    /** Japanese language code, may be used as source or target language. */
    const JAPANESE = 'ja';

    /** Lithuanian language code, may be used as source or target language. */
    const LITHUANIAN = 'lt';

    /** Latvian language code, may be used as source or target language. */
    const LATVIAN = 'lv';

    /** Dutch language code, may be used as source or target language. */
    const DUTCH = 'nl';

    /** Polish language code, may be used as source or target language. */
    const POLISH = 'pl';

    /** Portuguese language code, may only be used as a source language. */
    const PORTUGUESE = 'pt';

    /** Brazilian Portuguese language code, may only be used as a target language. */
    const PORTUGUESE_BRAZILIAN = 'pt-BR';

    /** European Portuguese language code, may only be used as a target language. */
    const PORTUGUESE_EUROPEAN = 'pt-PT';

    /** Romanian language code, may be used as source or target language. */
    const ROMANIAN = 'ro';

    /** Russian language code, may be used as source or target language. */
    const RUSSIAN = 'ru';

    /** Slovak language code, may be used as source or target language. */
    const SLOVAK = 'sk';

    /** Slovenian language code, may be used as source or target language. */
    const SLOVENIAN = 'sl';

    /** Swedish language code, may be used as source or target language. */
    const SWEDISH = 'sv';

    /** Chinese language code, may be used as source or target language. */
    const CHINESE = 'zh';

    /**
     * Changes the upper- and lower-casing of the given language code to match ISO 639-1 with an optional regional code
     * from ISO 3166-1.
     * @param string $langCode String containing language code to standardize.
     * @return string String containing the standardized language code.
     * @throws DeepLException If language code is an empty string.
     */
    public static function standardizeLanguageCode(string $langCode): string
    {
        if (strlen($langCode) === 0) {
            throw new DeepLException('langCode must be a non-empty string');
        }

        $exploded = explode('-', $langCode, 2);

        if (isset($exploded[1])) {
            return strtolower($exploded[0]) . '-' . strtoupper($exploded[1]);
        } else {
            return strtolower($exploded[0]);
        }
    }
}
