@forelse ($payments ?? [] as $payment)
    <tr>
        <td>{{ $payment->id }}</td>
        <td>{{ $payment->user->name }}</td>
        <td>{{ __('payment_methods.'.$payment->payment_method.'.title') }}</td>
        <td>{{ $payment->paymentable->name }}</td>
        <td>{{ $payment->payment_data['duration'] }} @lang($payment->payment_data['duration_type'])</td>
        <td>{{ price_format($payment->amount) }} @lang(config('app.currency'))</td>
        <td><span class="badge bg-{{ $payment->status_color }}">{{ $payment->status_text }}</span></td>
        <td style="max-width: 150px;">{{ __($payment->description) }}</td>
        <td><a type="button" class="button py-1" target="_blank" href="{{ route('backend.subscriptions-management.review-payment', $payment->id) }}" >
            <i class="bi bi-eye"></i> @lang('Review')
        </a></td>
    </tr>
@empty
    <div class="p-3 no-data">
        @lang('No Data')
    </div>
@endforelse

