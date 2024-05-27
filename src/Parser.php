<?php

namespace Bergo\Whisper2Webvtt;

class Parser
{
    public function convert(string $jsonContent): string
    {
        $content = json_decode($jsonContent, true);

        $vtt = '';
        $vtt .= "WEBVTT\n\n";

        if (empty($content['segments'])) {
            return $vtt;
        }

        foreach($content['segments'] as $seg) {
            $start = $this->formatTime($seg['start']);
            $end = $this->formatTime($seg['end']);
            $text = $seg['text'];

            $vtt .= "$start --> $end\n";
            $vtt .= "$text\n\n";
        }
        return $vtt;
    }

    function formatTime($nanoseconds) {
        $milliseconds = $nanoseconds / 1000000;
        $seconds = floor($milliseconds / 1000);
        $ms = $milliseconds % 1000;
    
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
    
        return sprintf('%02d:%02d:%02d.%03d', $hours, $minutes, $seconds, $ms);
    }
}