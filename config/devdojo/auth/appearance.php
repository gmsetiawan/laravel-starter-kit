<?php

/*
 * Branding configs for your application
 */

return [
    'logo' => [
        'type' => 'image',
        'image_src' => '/storage/auth/logo.png',
        'svg_string' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Zm-7.518-.267A8.25 8.25 0 1 1 20.25 10.5M8.288 14.212A5.25 5.25 0 1 1 17.25 10.5" />
</svg>
',
        'height' => '128',
    ],
    'background' => [
        'color' => '#000000',
        'image' => '/storage/auth/background.png',
        'image_overlay_color' => '#000000',
        'image_overlay_opacity' => '0',
    ],
    'color' => [
        'text' => '#212936',
        'button' => '#09090b',
        'button_text' => '#ffffff',
        'input_text' => '',
        'input_border' => '#212936',
    ],
    'alignment' => [
        'heading' => 'center',
        'container' => 'left',
    ],
    'favicon' => [
        'light' => '/storage/auth/favicon.png',
        'dark' => '/storage/auth/favicon-dark.png',
    ],
];
