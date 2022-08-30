<?php

return [
    'artworks' => [
        'new_message' => [
            'title' =>  'رسالة جديدة عن عمل فني',
            'description' =>  'لديك رسالة جديدة عن العمل الفني <b>:title</b>',
            'icon' => 'bi bi-chat-left-text',
            'bg_class' => 'bg-success',
        ],
    ],
    'subscription' => [
        'new_pending_payment' => [
            'title' =>  'عملية دفع لإشتراك بباقة بإنتظار الموافقة',
            'description' =>  'يوجد عملية دفع لإشتراك بباقة بإنتظار الموافقة من طرف <b>:fromUser_name</b>',
            'icon' => 'bi bi-bank',
            'bg_class' => 'bg-info',
        ],'payment_confirmed' => [
            'title' =>  'تم تأكيد عملية الدفع للإشتراك',
            'description' =>  'مبروك! تم تأكيد عملية الدفع للإشتراك الخاص بك',
            'icon' => 'bi bi-patch-check',
            'bg_class' => 'bg-success',
        ]
    ]
];
