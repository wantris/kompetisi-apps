@extends('template')

@section('title', $slug)


@section('content')

<div class="container my-5">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3 white-bg pad-4">
            <div class="card border">
                <div class="card-body" id="">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="{{url('assets/img/banner-komp/example.jpeg')}}" class="img-fluid registration-komp-banner" alt="Responsive image">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h1 class="registration-komp-title float-left">Pendaftaran Tim</h1>
                            <a href="#" id="add-button" class="btn-add-person float-right"><i class="fas fa-plus"></i></a>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="" class="registration-komp-label">Ketua Tim</label>
                            <input type="text" disabled value="Jhon Doe" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="" class="registration-komp-label">Anggota 1</label>
                            <div class="form-group">
                                <select name="ketua" class="select-single" style="width: 100%">
                                    <option value="">Jhon Doe</option>
                                    <option value="">Category 1</option>
                                    <option value="">Category 2</option>
                                    <option value="">Category 3</option>
                                    <option value="">Category 4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="add-anggota">

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mt-4 text-center">
                                <input type="submit" class="btn-login-mhs mt-3" style="background-color: #fb8c00 !important; border-color:#fb8c00 " value="Daftarkan Tim">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('cs-script')
    <script>
        let id = 1;

        // add row func
        $("#add-button").click(function () {
            event.preventDefault();
            id = id +1;
            var html = '';
            html = ` <div class="row mt-3" id="inputFormRow">
                        <div class="col-12">
                            <label for="" class="registration-komp-label">Anggota ${id}</label>
                            <a href="#" id="remove-button" class="btn-add-person float-right" style="padding: 4px 4px; background-color:red !important; border-color:red"><i class="fas fa-trash"></i></a>
                            <select name="anggota_${id}" class="select-single" style="width: 100%">
                                <option value="">Jhon Doe</option>
                                <option value="">Category 1</option>
                                <option value="">Category 2</option>
                                <option value="">Category 3</option>
                                <option value="">Category 4</option>
                            </select>
                        </div>
                    </div>`;

            $('#add-anggota').append(html);
            $('.select-single').each(function () {
                $('.select-single').select2();
            });
        });

         // remove row
         $(document).on('click', '#remove-button', function () {
            event.preventDefault();
            $(this).closest('#inputFormRow').remove();
        });
    </script>
@endpush