<?php

// Copyright 2022 DeepL SE (https://www.deepl.com)
// Use of this source code is governed by an MIT
// license that can be found in the LICENSE file.

namespace DeepL;

/**
 * Options that can be specified when translating text.
 * @see Translator::translateText()
 */
final class TranslateTextOptions
{
    /**
     * Specifies how input translation text should be split into sentences.
     * - 'on': Input translation text will be split into sentences using both newlines and
     *   punctuation, this is the default behaviour.
     * - 'off': Input translation text will not be split into sentences. This is advisable for
     *   applications where each input translation text is only one sentence.
     * - 'nonewlines': Input translation text will be split into sentences using only punctuation
     *   but not newlines.
     */
    const SPLIT_SENTENCES = 'split_sentences';

    /** Set to true to prevent the translation engine from correcting some formatting aspects, and
     * instead leave the formatting unchanged, default is false. */
    const PRESERVE_FORMATTING = 'preserve_formatting';

    /** Controls whether translations should lean toward formal or informal language. */
    const FORMALITY = 'formality';

    /** Type of tags to parse before translation, options are 'html' and 'xml'. */
    const TAG_HANDLING = 'tag_handling';

    /** Set to false to disable automatic tag detection, default is true. */
    const OUTLINE_DETECTION = 'outline_detection';

    /** List of XML tags that should be used to split text into sentences. */
    const SPLITTING_TAGS = 'splitting_tags';

    /** List of XML tags that should not be used to split text into sentences. */
    const NON_SPLITTING_TAGS = 'non_splitting_tags';

    /** List of XML tags containing content that should not be translated. */
    const IGNORE_TAGS = 'ignore_tags';

    /** Set to string containing a glossary ID to use the glossary for translation. */
    const GLOSSARY = 'glossary';
}
