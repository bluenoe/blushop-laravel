<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Announcement Bar Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the global announcement bar that appears at the top of the site.
    | You can set the message here or use the translation file for i18n support.
    |
    */

    // The main announcement message (supports HTML if needed)
    // If you want to use translations instead, leave this empty and use: __('announcement.message')
    'message' => env('ANNOUNCEMENT_MESSAGE', '🎉 Free Shipping on Orders Over $50! Use Code: FREESHIP50'),

    // localStorage key used to remember if user dismissed the bar
    'storage_key' => 'hide_promo_bar',

    // Enable or disable the announcement bar globally
    'enabled' => env('ANNOUNCEMENT_ENABLED', true),

];
