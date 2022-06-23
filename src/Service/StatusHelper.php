<?php

namespace App\Service;

class StatusHelper
{
    public function generateIcons()
    {
        return [
            'minus_gear' => "bi-patch-minus-fill",
            'clock' => "bi bi-stopwatch-fill",
            'progress' => "bi bi-app-indicator",
            'archive' => "bi bi-archive-fill",
            'arrow_down' => "bi bi-arrow-down-circle-fill",
            'arrow_up' => "bi bi-arrow-up-square-fill",
            'backspace' => "bi bi-backspace-fill",
            'medal' => "bi bi-award-fill",
            'chart' => "bi bi-bar-chart-fill",
            'bell' => "bi bi-bell-slash-fill",
            'bookmark' => "bi bi-bookmark-star-fill",
            'bucket' => "bi bi-bucket-fill",
            'calendar' => "bi bi-calendar-fill",
            'arrow' => "bi bi-capslock-fill",
            'chat' => "bi bi-chat-dots-fill",
            'check' => "bi bi-check-square-fill",
            'clipboard' => "bi bi-clipboard-x-fill",
            'minus' => "bi bi-dash-square-fill",
            'alert' => "bi bi-exclamation-octagon-fill",
            'gear' => "bi bi-gear-fill",
            'info' =>  "bi bi-info-circle-fill",
            'lighting' => "bi bi-lightning-fill",
            'megaphone' => "bi bi-megaphone-fill",
            'question' => "bi bi-question-octagon-fill",
            'star' => "bi bi-star-fill"
        ];
    }
    public function generatePicker()
    {
        return [
            'minus gear' => "minus_gear",
            'clock' => "clock",
            'progress' => "progress",
            'archive' => "archive",
            'arrow down' => "arrow_down",
            'arrow up' => "arrow_up",
            'backspace' => "backspace",
            'medal' => "medal",
            'chart' => "chart",
            'bell' => "bell",
            'bookmark' => "bookmark",
            'bucket' => "bucket",
            'calendar' => "calendar",
            'arrow' => "arrow",
            'chat' => "chat",
            'check' => "check",
            'clipboard' => "clipboard",
            'minus' => "minus",
            'alert' => "alert",
            'gear' => "gear",
            'info' =>  "info",
            'lighting' => "lighting",
            'megaphone' => "megaphone",
            'question' => "question",
            'star' => "star"
        ];
    }
}