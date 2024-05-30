<?php

use PHPUnit\Framework\TestCase;
use Bergo\Whisper2Webvtt\Parser;

class ParserTest extends TestCase
{
    public function testFormatTimeWithZero()
    {
        $this->assertEquals('00:00:00.000', (new Parser())->formatTime(0));
    }

    public function testFormatTimeWithMilliseconds()
    {
        $this->assertEquals('00:00:00.500', (new Parser())->formatTime(500000000));
    }

    public function testFormatTimeWithSeconds()
    {
        $this->assertEquals('00:00:05.000', (new Parser())->formatTime(5000000000));
    }

    public function testFormatTimeWithMinutes()
    {
        $this->assertEquals('00:01:00.000', (new Parser())->formatTime(60000000000));
    }

    public function testFormatTimeWithHours()
    {
        $this->assertEquals('01:00:00.000', (new Parser())->formatTime(3600000000000));
    }

    public function testFormatTimeComplex()
    {
        $this->assertEquals('01:23:45.678', (new Parser())->formatTime(5025678000000));
    }

    public function testEmpty()
    {
        $content = "";
        $this->assertEquals((new Parser())->convert($content), self::empty_result());
    }

    public function testInvalidJson()
    {
        $content = '{"test": "bla"}';
        $this->assertEquals((new Parser())->convert($content), self::empty_result());
    }

    public function testValidConvert()
    {
        $content = file_get_contents(__DIR__.'/fixtures/test-output.json');
        $output = (new Parser())->convert($content);

        $this->assertStringEqualsFile(__DIR__.'/fixtures/test-output.vtt', $output);
    }

    public function testConvertToWebVTTSingleSegment()
    {
        $jsonInput = '{
            "segments": [
              {
                "id": 0,
                "start": 123456789,
                "end": 987654321,
                "text": "Single segment test.",
                "tokens": [123, 456, 789]
              }
            ],
            "text": "Single segment test."
        }';

        $expected = "WEBVTT\n\n";
        $expected .= "00:00:00.123 --> 00:00:00.987\nSingle segment test.\n\n";

        $this->assertEquals($expected, (new Parser())->convert($jsonInput));
    }

    private static function empty_result()
    {
        return "WEBVTT\n\n";
    }
}
