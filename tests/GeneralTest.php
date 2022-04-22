<?php

// Copyright 2022 DeepL SE (https://www.deepl.com)
// Use of this source code is governed by an MIT
// license that can be found in the LICENSE file.

namespace DeepL;

class GeneralTest extends DeepLTestBase
{
    public function testEmptyAuthKey()
    {
        $this->expectException(DeepLException::class);
        new Translator('', [TranslatorOptions::SERVER_URL => $this->serverUrl]);
    }

    public function testInvalidAuthKey()
    {
        $translator = new Translator('invalid', [TranslatorOptions::SERVER_URL => $this->serverUrl]);

        $this->expectException(AuthorizationException::class);
        $translator->getUsage();
    }

    public function testUsage()
    {
        $translator = $this->makeTranslator();
        $usage = $translator->getUsage();
        $this->assertStringContainsString('Usage this billing period', strval($usage));
    }

    public function testLogger()
    {
        $logger = new TestLogger();
        $translator = $this->makeTranslator([TranslatorOptions::LOGGER => $logger]);
        $translator->getUsage();
        $this->assertStringContainsString("Request to DeepL API", $logger->content);
        $this->assertStringContainsString("DeepL API response", $logger->content);
    }

    public function testLanguage()
    {
        $translator = $this->makeTranslator();
        $sourceLanguages = $translator->getSourceLanguages();
        foreach ($sourceLanguages as $sourceLanguage) {
            if ($sourceLanguage->code === 'en') {
                $this->assertEquals('English', $sourceLanguage->name);
            }
            $this->assertNull($sourceLanguage->supportsFormality);
        }

        $targetLanguages = $translator->getTargetLanguages();
        foreach ($targetLanguages as $targetLanguage) {
            if ($targetLanguage->code === 'de') {
                $this->assertEquals('German', $targetLanguage->name);
            }
            $this->assertNotNull($targetLanguage->supportsFormality);
        }
    }

    public function testUsageNoResponse()
    {
        $this->needsMockServer();
        $this->sessionNoResponse = 2;
        $translator = $this->makeTranslator([TranslatorOptions::MAX_RETRIES => 0, TranslatorOptions::TIMEOUT => 1.0]);

        $this->expectException(ConnectionException::class);
        $translator->getUsage();
    }

    public function testTranslateTooManyRequests()
    {
        $this->needsMockServer();
        $this->session429Count = 2;
        $translator = $this->makeTranslator([TranslatorOptions::MAX_RETRIES => 1, TranslatorOptions::TIMEOUT => 1.0]);

        $this->expectException(TooManyRequestsException::class);
        $translator->translateText(DeepLTestBase::EXAMPLE_TEXT['en'], null, 'de');
    }

    public function testUsageOverrun()
    {
        $this->needsMockServer();
        $characterLimit = 20;
        $documentLimit = 1;
        $this->sessionInitCharacterLimit = $characterLimit;
        $this->sessionInitDocumentLimit = $documentLimit;

        $translator = $this->makeTranslatorWithRandomAuthKey();
        $usage = $translator->getUsage();
        $this->assertFalse($usage->anyLimitReached());
        $this->assertEquals($characterLimit, $usage->character->limit);
        $this->assertEquals($documentLimit, $usage->document->limit);
        $this->assertStringContainsString('Characters: 0 of 20', strval($usage));
        $this->assertStringContainsString('Documents: 0 of 1', strval($usage));

        $translator->translateText(str_repeat('a', $characterLimit), null, 'de');

        $usage = $translator->getUsage();
        $this->assertTrue($usage->anyLimitReached());
        $this->assertTrue($usage->character->limitReached());
        $this->assertFalse($usage->document->limitReached());
        $this->assertNull($usage->teamDocument);

        $this->expectException(QuotaExceededException::class);
        $translator->translateText(str_repeat('a', $characterLimit), null, 'de');
    }
}
