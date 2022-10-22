<?php

return [
    'app' => [
        'favicon'           => 'favicon.ico',
        'logo'              => 'logos/art-logo.png',
        'timezone'          => 'Asia/Riyadh',
        'date_format'       => 'd M Y',
        'default_avatar'    => 'avatars/defaults/default-avatar.png',
        'store_default_avatar'      => 'avatars/defaults/store-avatar.png',
        'artist_default_avatar'     => [
            'male' => 'avatars/defaults/artist-avatar.png',
            'female' => 'avatars/defaults/fartist-avatar.png'
        ],
        'max_upload_size'   => 3072,
        'currency'          => 'SAR',
        'seo'               => [
            'description' => 'منصة فن أرت',
            'keywords'    => 'فن ارت, fan art, منصة فن  ارت, بيع لوحات, اعمال فنية'
        ],
        'ads'               => [
            'home_banner_ad' => '<a href="#"><img src="/assets/images/ad-placeholder/ad.png" alt="Ad"></a>'
        ],
        'subscription' => [
            'free_trial_days' => 90
        ]
    ]
];
