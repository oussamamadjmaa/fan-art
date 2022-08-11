@if (session()->has('verified'))
<script type="module">
    window.Swal.fire({
        icon: 'success',
        title: "{{ __('Email verified successfully!') }}",
        confirmButtonText: "{{ __('Close') }}"
    })
</script>
@endif
