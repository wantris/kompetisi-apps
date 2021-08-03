<script src="{{url('assets/deskapp/vendors/scripts/core.js')}}"></script>
<script src="{{url('assets/deskapp/vendors/scripts/script.min.js')}}"></script>
<script src="{{url('assets/deskapp/vendors/scripts/process.js')}}"></script>
<script src="{{url('assets/deskapp/vendors/scripts/layout-settings.js')}}"></script>
{{-- <script src="{{url('assets/deskapp/src/plugins/apexcharts/apexcharts.min.js')}}"></script> --}}
<script src="{{url('assets/deskapp/src/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{url('assets/deskapp/vendors/scripts/datatable-setting.js')}}"></script>
<script src="{{url('assets/deskapp/vendors/scripts/dashboard.js')}}"></script>

<script src="{{url('assets/deskapp/src/plugins/jQuery-Knob-master/jquery.knob.min.js')}}"></script>
{{-- <script src="{{url('assets/deskapp/src/plugins/highcharts-6.0.7/code/highcharts.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/highcharts-6.0.7/code/highcharts-more.js')}}"></script> --}}
{{-- <script src="{{url('assets/deskapp/src/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script> --}}
<script src="{{url('assets/deskapp/vendors/scripts/dashboard2.js')}}"></script>

<!-- buttons for Export datatable -->
<script src="{{url('assets/deskapp/src/plugins/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/datatables/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/datatables/js/buttons.print.min.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/datatables/js/buttons.flash.min.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/datatables/js/pdfmake.min.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/datatables/js/vfs_fonts.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

{{-- Notiflix --}}
<script src="{{url('assets/notiflix/dist/notiflix-2.7.0.min.js')}}"></script>
<script src="{{url('assets/notiflix/dist/notiflix-aio-2.7.0.min.js')}}"></script>

{{-- Select2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@if (session()->has('failed'))
    <script>
        console.log("asdad")
        Notiflix.Notify.Failure("{{ Session::get('failed') }}");
    </script>
@endif

@if (session()->has('success'))
    <script>
        Notiflix.Notify.Success("{{ Session::get('success') }}");
    </script>
@endif