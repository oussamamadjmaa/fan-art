<?php

return [
    'artworks' => [
        'new_message' => [
            'title' =>  'New message about artwork',
            'description' =>  'You have new message about your artwork <b>:title</b>',
            'icon' => 'bi bi-chat-left-text',
            'bg_class' => 'bg-success',
        ],
    ],
    'subscription' => [
        'new_pending_payment' => [
            'title' =>  'New payment waiting approval for plan subscription',
            'description' =>  'New payment for plan subscription is waiting approval from <b>:fromUser_name</b>',
            'icon' => 'bi bi-bank',
            'bg_class' => 'bg-info',
        ],'payment_confirmed' => [
            'title' =>  'Your payment has been confirmed',
            'description' =>  'Congrats! Your subscription payment has been confirmed',
            'icon' => 'bi bi-patch-check',
            'bg_class' => 'bg-success',
        ],'payment_declined' => [
            'title' =>  'Your payment has been declined',
            'description' =>  'Unfortunately! Your subscription payment has been declined',
            'icon' => 'bi bi-patch-check',
            'bg_class' => 'bg-danger',
        ]
    ]
];
