@forelse ($payments ?? [] as $payment)
    <tr>
        <td>{{ $payment->id }}</td>
        <td>{{ __('payment_methods.'.$payment->payment_method.'.title') }}</td>
        <td>{{ $payment->paymentable->name }} @if($payment->payment_method != "free_trial") ({{ __(($payment->payment_data['type'] ?? 'upgrade_plan') == "upgrade_plan" ? "Upgrade" : "Renew")}}) @endif</td>
        <td>{{ $payment->payment_data['duration'] }} @lang($payment->payment_data['duration_type'])</td>
        <td>{{ price_format($payment->amount) }} @lang(config('app.currency'))</td>
        <td><span class="badge bg-{{ $payment->status_color }}">{{ $payment->status_text }}</span></td>
        <td>{{ $payment->created_at->translatedFormat('d M Y h:i A') }}</td>
        <td style="max-width: 150px;">{{ __($payment->description) }}</td>
    </tr>
@empty
    <div class="p-3 no-data">
        @lang('No Data')
    </div>
@endforelse

