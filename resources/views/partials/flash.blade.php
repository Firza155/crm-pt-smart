{{-- GLOBAL FLASH MESSAGE --}}
<div id="global-flash"></div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const container = document.getElementById('global-flash');

    // 1. Flash dari sessionStorage (fetch-based)
    const success = sessionStorage.getItem('flash_success');
    const error   = sessionStorage.getItem('flash_error');
    const warning = sessionStorage.getItem('flash_warning');

    if (success) {
        showFlash('success', success);
        sessionStorage.removeItem('flash_success');
    }

    if (error) {
        showFlash('danger', error);
        sessionStorage.removeItem('flash_error');
    }

    if (warning) {
        showFlash('warning', warning);
        sessionStorage.removeItem('flash_warning');
    }

    // 2. Flash dari Laravel session (redirect-based)
    @if(session('success'))
        showFlash('success', @json(session('success')));
    @endif

    @if(session('error'))
        showFlash('danger', @json(session('error')));
    @endif

    @if(session('warning'))
        showFlash('warning', @json(session('warning')));
    @endif

    function showFlash(type, message) {
        container.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    }
});
</script>
@endpush
