<?php
    return array(
        /* Url to link to when using the link method.
        *  The $file and $key sub-strings will be
         * replaced with the corresponding values
         *
         * example: '/translations/index/$file/#$key'
         * for key: 'users.username'
         * url: 'http://example.com/translations/index/users/#username
         */
        'link_url' => '/translations/index/$file/#$key',

        /* Default method to use to show the translations
         * Available methods:
         * show_key - show the key instead of the translation
         * link - show the translation, but link it to the link_url
         *
         * Can be overwritten by sending it as an input flag
         */
        'default_method' => "show_key",

        /* The input flag used to trigger the debugging
         *
         * Example: 'http://example.com/?lang_debug=true
         */
        'input_flag' => 'lang_debug',
    );
?>