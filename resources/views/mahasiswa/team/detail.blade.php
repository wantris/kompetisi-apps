@extends('mahasiswa.app')

@section('title','Anggota Tim')

@push('css')
<link rel="stylesheet" type="text/css" href="{{url('assets/deskapp/vendors/styles/ribbon.css')}}">
@endpush

@section('content')

    <div class="container-fluid">
        <div class="pd-20">
            <div class="contact-directory-list">
                <ul class="row">
                    <li class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="contact-directory-box" style="position: relative">
                            <div class="ribbon ribbon-top-left"><span>Ketua</span></div>
                            <div class="contact-dire-info text-center">
                                <div class="contact-avatar">
                                    <span>
                                        <img src="{{url('assets/deskapp/vendors/images/photo2.jpg')}}" alt="">
                                    </span>
                                </div>
                                <div class="contact-name">
                                    <h4>Hifni Alimudin</h4>
                                    <p>Teknik informatika</p>
                                    <div class="work text-success"><i class="icon-copy dw dw-email-1 mr-1"></i>hifni@gmail.com</div>
                                </div>
                                <div class="profile-sort-desc">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing magna aliqua.
                                </div>
                            </div>
                            <div class="view-contact">
                                <a href="#">Lihat Profil</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@endsection