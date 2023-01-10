@props([
    'order'
])

<span @class([
    'badge',
    'bg-danger' => $order->isCanceled(),
    'bg-success' => $order->isConfirmed() || $order->isDelivered() || $order->isShipped(),
    'bg-info' => !$order->isConfirmed() && $order->isPaid(),
    'bg-secondary' => !$order->isConfirmed() && !$order->isPaid(),
])>
    {{
        $order->delivered_at ? __('Order Delivered') : (
            $order->shipped_at ? __('Order Shipped Out') : (
                $order->canceled_at != null ? __('Canceled') : (
                    $order->denied_at != null ? __('Denied'): (
                        $order->confirmed_at != null ? __('Order Confirmed') : (
                            $order->confirmed_at == null && $order->paid_at != null ? __('Awaiting payment confirmation') : __('Awaiting payment')
                        )
                    )
                )
            )
        )
    }}
</span>
