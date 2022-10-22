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
    'products' => [
        'new_message' => [
            'title' =>  'رسالة جديدة عن منتج',
            'description' =>  'لديك رسالة جديدة عن منتجك <b>:name</b>',
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
            'title' =>  'تم تأكيد عملية الدفع الخاصة بك',
            'description' =>  'مبروك! تم تأكيد عملية الدفع للإشتراك الخاص بك',
            'icon' => 'bi bi-patch-check',
            'bg_class' => 'bg-success',
        ],'payment_declined' => [
            'title' =>  'تم رفض عملية الدفع الخاصة بك',
            'description' =>  'للأسف! تم رفض عملية الدفع للإشتراك الخاص بك',
            'icon' => 'bi bi-patch-check',
            'bg_class' => 'bg-danger',
        ]
        ],
        'support_tickets' => [
            'new_ticket' => [
                'title' =>  'تم فتح تذكرة دعم جديدة',
                'description' =>  'تم فتح تذكرة دعم جديدة من طرف <b>:fromUser_name</b>',
                'icon' => 'fa fa-life-ring',
                'bg_class' => 'bg-info',
            ], 'new_message' => [
                'title' =>  'رسالة جديدة على تذكرة دعم',
                'description' =>  'تم ارسال رسالة جديدة على التذكرة رقم <b>:id</b>',
                'icon' => 'fa fa-life-ring',
                'bg_class' => 'bg-info',
            ],'ticket_closed' => [
                'title' =>  'تم إغلاق تذكرة دعم',
                'description' =>  'تم اغلاق تذكرة دعم رقم <b>:id</b>',
                'icon' => 'fa fa-life-ring',
                'bg_class' => 'bg-info',
            ],
        ]
];
