<!-- All JS Custom Plugins Link Here here -->
<script src="{{url('assets/js/vendor/modernizr-3.5.0.min.js')}}"></script>

<!-- Jquery, Popper, Bootstrap -->
<script src="{{url('assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
<script src="{{url('assets/js/popper.min.js')}}"></script>
<script src="{{url('assets/js/bootstrap.min.js')}}"></script>
<!-- Jquery Mobile Menu -->
<script src="{{url('assets/js/jquery.slicknav.min.js')}}"></script>

<!-- Jquery Slick , Owl-Carousel Plugins -->
<script src="{{url('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{url('assets/js/slick.min.js')}}"></script>
<script src="{{url('assets/js/price_rangs.js')}}"></script>

<!-- One Page, Animated-HeadLin -->
<script src="{{url('assets/js/wow.min.js')}}"></script>
<script src="{{url('assets/js/animated.headline.js')}}"></script>
<script src="{{url('assets/js/jquery.magnific-popup.js')}}"></script>

<!-- Scrollup, nice-select, sticky -->
<script src="{{url('assets/js/jquery.scrollUp.min.js')}}"></script>
{{-- <script src="{{url('assets/js/jquery.nice-select.min.js')}}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{url('assets/js/jquery.sticky.js')}}"></script>

<!-- contact js -->
<script src="{{url('assets/js/contact.js')}}"></script>
<script src="{{url('assets/js/jquery.form.js')}}"></script>
<script src="{{url('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{url('assets/js/mail-script.js')}}"></script>
<script src="{{url('assets/js/jquery.ajaxchimp.min.js')}}"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="{{url('assets/js/plugins.js')}}"></script>
<script src="{{url('assets/js/main.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{url('assets/notiflix/dist/notiflix-2.7.0.min.js')}}"></script>
<script src="{{url('assets/notiflix/dist/notiflix-aio-2.7.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.select-single').select2();

    });

    const showPasswordOrmawa = () => {
            let html = `
                <button type="button" onclick="hidePasswordOrmawa()" style="cursor: pointer" class="input-group-text"><i class="fas fa-eye-slash"></i></button>;
            `;
            if(!$('#btn-pw-ormawa').hasClass('show')){
                $('#password-ormawa-inp').attr('type','text');
                $('#btn-pw-ormawa').addClass('show');
                $('#btn-pw-ormawa').html(html);
            }
        } 

        const hidePasswordOrmawa = () => {
            let html = `
                <button type="button" onclick="showPasswordOrmawa()" style="cursor: pointer" class="input-group-text"><i class="fas fa-eye"></i></button>;
            `;
            if($('#btn-pw-ormawa').hasClass('show')){
                $('#password-ormawa-inp').attr('type','password');
                $('#btn-pw-ormawa').removeClass('show');
                $('#btn-pw-ormawa').html(html);
            }
        }
</script>