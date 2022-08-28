@forelse ($payments ?? [] as $payment)
    @if ($loop->first)
        <div class="table-reponsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('Payment Method')</th>
                        <th>@lang('Plan name')</th>
                        <th>@lang('Duration')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Payment Status')</th>
                        <th>@lang('Note')</th>
                    </tr>
                </thead>
                <tbody>
    @endif
    <tr>
        <td>{{ $payment->id }}</td>
        <td>{{ __('payment_methods.'.$payment->payment_method.'.title') }}</td>
        <td>{{ $payment->paymentable->name }}</td>
        <td>{{ $payment->payment_data['duration'] }} @lang($payment->payment_data['duration_type'])</td>
        <td>{{ price_format($payment->amount) }} @lang(config('app.currency'))</td>
        <td><span class="badge bg-{{ $payment->status_color }}">{{ $payment->status_text }}</span></td>
        <td style="max-width: 150px;">{{ __($payment->description) }}</td>
    </tr>
    @if ($loop->last)
                </tbody>
            </table>
        </div>
    @endif
@empty
    <div class="p-3 no-data">
        @lang('No Data')
    </div>
@endforelse

