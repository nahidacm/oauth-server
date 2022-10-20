<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

<!-- feather js -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>


<!-- Taost -->
<script src="{{ asset('assets/libs/toast/jquery.toast.min.js') }}"></script>
<!-- SweetAlert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- pace js -->
<script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>
<!-- datepicker js -->
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>

@stack('js_links')
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- custom js -->
@stack('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function siteUrlJs(url_portion) {
            return '<?php echo e(url('/')); ?>' + '/' + url_portion;
        }
        feather.replace()

        /**
        * @param   errors    validation error data from ajax request, array
        * @return            returns error listing, string
        */
        function getErrorHtml($errors) {
            var errorsHtml = '';
            $.each($errors, function (key, value) {

                if (value.constructor === Array) {
                    $.each(value, function (i, v) {

                        $("#id_"+key).show().html(v);
                        errorsHtml += '<li>' + v + '</li>';
                    });
                } else {
                    errorsHtml += '<li>' + value[0] + '</li>';
                }
            });
            return errorsHtml
        }

        $(document).ready(function () {
            $('.select2').select2();
        });

        $(".notification-menu").click(function(e){
            e.stopPropagation();
        })
    </script>

    {{-- @include('layouts.partial._js_notification') --}}

