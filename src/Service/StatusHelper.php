<?php

namespace App\Service;

class StatusHelper
{
    public function generateIcons()
    {
        $stateIcons = [
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
        return $stateIcons;
    }
}