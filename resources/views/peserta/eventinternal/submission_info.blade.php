@extends('peserta.app')

@section('title', 'Submission Info '.$slug)

@section('content')


    <div class="row my-5">
        <div class="col-12 mb-4">
            <h2 class="page-title-submission text-secondary"><span class="page-title-icon-submission mr-2"><i class="icon-copy dw dw-ferris-wheel text-white"></i></span>
                Submission Info
            </h2>
        </div>
        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Umum</strong>
                    <h4 class="float-right"><a href="#"><i class="icon-copy dw dw-back"></i></a></h4>
                </div>
                <div class="card-body row">
                    <dl class="col-md row mb-0 mt-2">
                        <dt class="col-lg-3 col-sm-12">Pengirim</dt>
                        <dd class="col-lg-9 col-sm-12">
                            <p class="form-control-static">
                                <a href="https://www.dicoding.com/users/638199" class="text-orange">
                                     Jhon Doe
                                </a>
                            </p>
                        </dd>
                        <dt class="col-lg-3 col-sm-12">kompetisi</dt>
                        <dd class="col-lg-9 col-sm-12">
                            <p class="form-control-static">
                                <a href="https://www.dicoding.com/academies/219" class="text-orange" title="Menjadi Front-End Web Developer Expert">
                                    Design Competition
                                </a>
                            </p>
                        </dd>
                        <dt class="col-lg-3 col-sm-12">Peserta</dt>
                        <dd class="col-lg-9 col-sm-12">
                            <p class="form-control-static">
                                <a href="https://www.dicoding.com/academies/219/tutorials/9301" class="text-orange" title="Submission: Katalog Restoran">
                                    Tim Maju Jaya
                                </a>
                            </p>
                            <p>
                                <a href="https://www.dicoding.com/students/638199/submissions" class="btn bg-orange text-white btn-md shadow">Seluruh Submission Peserta</a>
                            </p>
                        </dd>
                    </dl>
                    <dl class="col-md row mb-0">
                        <dt class="col-lg-3 col-sm-12">Submission ID</dt>
                        <dd class="col-lg-9 col-sm-12">
                            <p class="form-control-static">724425</p>
                        </dd>

                        <dt class="col-lg-3 col-sm-12">Terkirim</dt>
                        <dd class="col-lg-9 col-sm-12">
                            <p class="form-control-static">
                                16-May-2021 17:26:00
                            </p>
                        </dd>
                        <dt class="col-lg-3 col-sm-12">Status</dt>
                        <dd class="col-lg-9 col-sm-12">
                            <p class="form-control-static">
                                    <span class="text-success"><strong>Approved</strong></span>
                                    19-May-2021 16:33:52

                            </p>
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><strong>Hasil Review</strong></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-lg-3 col-sm-12">Catatan Review</dt>
                        <dd class="col-lg-9 col-sm-12 js-note fr-view">
                            <p><span>Hallo<strong>&nbsp;wantris</strong></span><span>,&nbsp;</span><span>Selamat! Kamu telah berhasil menyelesaikan tugas untuk <span>&nbsp;Submission: Katalog Restoran<strong>.</strong></span></span></p><p><span>Terima kasih telah sabar menunggu. Kami membutuhkan waktu untuk bisa memberikan feedback sekomprehensif mungkin kepada setiap peserta kelas. Untuk meningkatkan kualitas project submission yang dikirimkan, kamu dapat menerapkan beberapa saran berikut:</span></p><p><strong><span>Notes:</span></strong></p><ul><li>Sebaiknya tambahkan meta tag <strong>Description&nbsp;</strong>pada berkas html kamu untuk memberikan penjelasan singkat mengenai isi dari halaman web yang dibangun. Kamu bisa pelajari di <a href="https://web.dev/meta-description/?utm_source=lighthouse&amp;utm_medium=devtools" target="_blank" rel="noreferrer noopener">https://web.dev/meta-description/?utm_source=lighthouse&amp;utm_medium=devtools</a>.<br><br></li><li>Terdapat beberapa elemen yang memiliki rasio kontras yang rendah. Rasio kontras yang rendah dari warna teks terhadap background dapat menyebabkan teks sulit dibaca. Untuk selengkapnya, lebih lanjut kamu bisa membaca artikel ini: <a href="https://web.dev/color-contrast/?utm_source=lighthouse&amp;utm_medium=devtools" target="_blank" rel="noreferrer noopener">https://web.dev/color-contrast/?utm_source=lighthouse&amp;utm_medium=devtools</a><p>Untuk memeriksa ini, kamu bisa menggunakan tools seperti <a href="https://developers.google.com/web/tools/lighthouse" target="_blank" rel="noreferrer noopener"><strong>LightHouse</strong></a><strong>&nbsp;</strong>yang ada di chrome. Dan ditemukan beberapa element berikut :<br><img src="https://dicodingacademy.blob.core.windows.net/academies/2021051916260231de13218b4ceeca74c61f19429868ef.png" style="width:397px;" class="fr-fic fr-dib" alt="2021051916260231de13218b4ceeca74c61f19429868ef.png"></p></li><li>Perhatikan tampilan berikut:</li></ul><p style="margin-left:40px;"><img src="https://dicodingacademy.blob.core.windows.net/academies/20210519162736ec0345d3ca56dbb9d93dbe0770c52974.png" style="width:415px;" class="fr-fic fr-dib" alt="20210519162736ec0345d3ca56dbb9d93dbe0770c52974.png"></p><p style="margin-left:40px;">Nampaknya pada gambar tersebut masih belum ditampilkan sesuai dengan aspect rationya, sehingga terlihat memanjang. Untuk case ini, kamu bisa menerapkan style <em>center crop&nbsp;</em>dengan rule <strong>object-fit: cover.</strong></p><ul><li>Perhatikan tampilan berikut :<br><img src="https://dicodingacademy.blob.core.windows.net/academies/2021051916302941141eb8b0d18dd17bd1eaeccf897735.png" style="width:527px;" class="fr-fic fr-dib" alt="2021051916302941141eb8b0d18dd17bd1eaeccf897735.png"></li></ul><p style="margin-left:40px;">Sebaiknya gunakanlah ukuran teks yang besar supaya text bisa dibaca dengan mudah. Untuk minimal ukuran dari sebuah text adalah <strong>12pt.&nbsp;</strong>SIlakan diterapkan ya.</p><p><span><strong><br></strong></span>Tetap semangat menyelesaikan kelas <em>Menjadi Front-End Web Developer Expert</em><strong>.</strong></p><p><span>Silakan berkunjung ke&nbsp;</span><span><a href="https://www.dicoding.com/academies/219/discussions" target="_blank" rel="noreferrer noopener">forum diskusi kelas</a> saat mengalami kesulitan dalam mengerjakan submission berikutnya</span><span>. Jika memiliki pertanyaan atau saran terkait kelas, silakan email ke&nbsp;</span><a href="mailto:%20academy@dicoding.com"><span>academy@dicoding.com</span></a><span>.</span></p><hr><p style="text-align:right;"><em>Salam</em></p><p style="text-align:right;"><span><span style="color:rgb(0,0,0);">Dicoding Reviewer</span></span></p>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

@endsection