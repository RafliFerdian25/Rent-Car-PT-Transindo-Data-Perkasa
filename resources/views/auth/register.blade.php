@extends('auth.layout')

@section('authContent')
    {{-- main content --}}
    <main>
        <!-- sign up area start -->
        <section class="signup__area p-relative z-index-1 pb-145" style="padding-top: 54px">
            <div class="sign__shape">
                <img class="man-1" src="{{ asset('assets/img/decoration/man-1.png') }}" alt="decoration-man-1">
                <img class="man-2" src="{{ asset('assets/img/decoration/man-2.png') }}" alt="decoration-man-2">
                <img class="circle" src="{{ asset('assets/img/decoration/circle.png') }}" alt="decoration-circle">
                <img class="zigzag" src="{{ asset('assets/img/decoration/zigzag.png') }}" alt="decoration-zigzag">
                <img class="dot" src="{{ asset('assets/img/decoration/dot.png') }}" alt="decoration-dot">
                <img class="bg" src="{{ asset('assets/img/decoration/sign-up.png') }}" alt="decoration-sign-up">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xxl-8 offset-xxl-2 col-xl-8 offset-xl-2">
                        <div class="section__title-wrapper text-center" style="margin-bottom: 44px">
                            <h2 class="section__title mb-2">Daftar Akun</h2>
                            <p>
                                Silahkan daftar akun untuk melakukan peminjaman mobil
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-6 offset-xxl-3 col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                        <div class="sign__wrapper white-bg">
                            <div class="sign__form">
                                <form method="POST" id="registerForm">
                                    @csrf
                                    {{-- email --}}
                                    <div class="sign__input-wrapper mb-15">
                                        <label for="email">
                                            <h5>Email</h5>
                                        </label>
                                        <div class="sign__input">
                                            <i class="fal fa-user icon-form"></i>
                                            <input type="text" placeholder="Masukan email" name="email" id="email"
                                                required value="" class="input-form">
                                        </div>
                                    </div>
                                    {{-- password --}}
                                    <div class="sign__input-wrapper mb-15">
                                        <label for="password">
                                            <h5>Kata Sandi</h5>
                                        </label>
                                        <div class="sign__input">
                                            <i class="fal fa-lock icon-form"></i>
                                            <div class="toggle-eye-wrapper"><i
                                                    class="fa-regular fa-eye toggle-eye icon-toggle-password"></i></div>
                                            <input type="password" placeholder="Masukan kata sandi" value=""
                                                name="password" id="password" class="input-form">
                                        </div>
                                    </div>
                                    {{-- name --}}
                                    <div class="sign__input-wrapper mb-15">
                                        <label for="name">
                                            <h5>Nama</h5>
                                        </label>
                                        <div class="sign__input">
                                            <i class="fal fa-user icon-form"></i>
                                            <input type="text" placeholder="Masukan name" name="name" id="name"
                                                required class="input-form">
                                        </div>
                                    </div>
                                    {{-- address --}}
                                    <div class="sign__input-wrapper mb-15">
                                        <label for="alamat">
                                            <h5>Alamat</h5>
                                        </label>
                                        <div class="sign__input">
                                            <i class="fal fa-map icon-form"></i>
                                            <input type="text" placeholder="Masukan alamat" name="alamat" id="alamat"
                                                required class="input-form">
                                        </div>
                                    </div>
                                    {{-- phone --}}
                                    <div class="sign__input-wrapper mb-15">
                                        <label for="phone">
                                            <h5>No. Telepon</h5>
                                        </label>
                                        <div class="sign__input">
                                            <i class="fal fa-phone icon-form"></i>
                                            <input type="text" placeholder="Masukan no. telepon" name="phone"
                                                id="phone" required class="input-form">
                                        </div>
                                    </div>
                                    {{-- driving_license --}}
                                    <div class="sign__input-wrapper mb-15">
                                        <label for="driving_license">
                                            <h5>No. SIM</h5>
                                        </label>
                                        <div class="sign__input">
                                            <i class="fal fa-id-card icon-form"></i>
                                            <input type="text" placeholder="Masukan no. SIM" name="driving_license"
                                                id="driving_license" required class="input-form">
                                        </div>
                                    </div>
                                    <button id="registerButton" class="tp-btn w-100 rounded-pill">Masuk</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- sign up area end -->
    </main>
@endsection

@section('script')
    <script>
        // validate form
        $("#registerForm").validate({
            rules: {
                email: {
                    required: true,
                },
                password: {
                    required: true,
                }
            },
            messages: {
                email: {
                    required: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Email tidak boleh kosong',
                },
                password: {
                    required: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Kata sandi tidak boleh kosong',
                }
            },
            submitHandler: function(form) {
                $('#registerButton').html('<i class="fas fa-circle-notch text-lg spinners-2"></i>');
                $('#registerButton').prop('disabled', true);
                $.ajax({
                    url: "{{ url('login') }}",
                    type: "POST",
                    data: {
                        email: $('#email').val(),
                        password: $('#password').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#registerButton').html('Masuk');
                        $('#registerButton').prop('disabled', false);
                        window.location.href = response.data.redirect
                    },
                    error: function(xhr, status, error) {
                        $('#registerButton').html('Masuk');
                        $('#registerButton').prop('disabled', false);
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message == "CSRF token mismatch.") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Gagal!',
                                    text: "Mohon maaf email/password Anda tidak sesuai",
                                })
                                location.reload()
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Gagal!',
                                    text: xhr.responseJSON.meta.message,
                                })
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Gagal!',
                                text: "Terjadi kegagalan, silahkan coba beberapa saat lagi! Error: " +
                                    error,
                            })
                        }
                        return false;
                    }
                });
            }
        });

        // toggle-eye-wrapper
        $('.toggle-eye-wrapper').click(function() {
            if ($('#password').attr('type') == 'password') {
                $('#password').attr('type', 'text');
                $('.toggle-eye-wrapper').html(
                    '<i class="fa-regular fa-eye-slash toggle-eye icon-toggle-password"></i>');
            } else {
                $('#password').attr('type', 'password');
                $('.toggle-eye-wrapper').html(
                    '<i class="fa-regular fa-eye toggle-eye icon-toggle-password"></i>');
            }
        });
    </script>
@endsection
