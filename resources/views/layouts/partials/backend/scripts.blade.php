<!-- Javascript -->
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/theme.min.js') }}"></script>

<script src="{{ asset('assets/js/vendors/jquery.min.js') }}"></script>

<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src=" {{ asset('assets/js/vendors/chart.js') }}"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- CSRF Token Setup -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<!-- Additional JavaScript from pages -->
@stack('scripts')

<!-- SweetAlert Laravel Integration - Modified to prevent repeated alerts -->
@if(session()->has('sweet_alert'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('sweet_alert.type') === 'success')
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('sweet_alert.message') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @elseif(session('sweet_alert.type') === 'error')
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('sweet_alert.message') }}',
                    showConfirmButton: true
                });
            @elseif(session('sweet_alert.type') === 'warning')
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: '{{ session('sweet_alert.message') }}',
                    showConfirmButton: true
                });
            @elseif(session('sweet_alert.type') === 'info')
                Swal.fire({
                    icon: 'info',
                    title: 'Info!',
                    text: '{{ session('sweet_alert.message') }}',
                    showConfirmButton: true
                });
            @endif
        });
    </script>
@endif
