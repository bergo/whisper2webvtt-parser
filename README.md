# whisper2webvtt-parser

PHP library to convert whisper json output to WebVTT format.

## Installation

    composer require bergo/whisper2webvtt-parser

## Usage

    use Bergo\Whisper2Webvtt\Parser;

    $parser = new Bergo\Whisper2Webvtt\Parser();

    $json = '{"segments": [
      {
        "id": 0,
        "start": 0,
         "end": 5000000000,
        "text": "Dies ist eine kleine Testaufnahme für den WebVTT-Paser.",
        "tokens": [
          50364,
          10796,
          1418,
          3018,
          22278,
          9279,
          9507,
          32796,
          2959,
          1441,
          9573,
          53,
          28178,
          12,
          47,
          17756,
          13,
          50614
        ]
      },
      {
        ...
      }
    ]';
    $result = $parser->convert($json);
