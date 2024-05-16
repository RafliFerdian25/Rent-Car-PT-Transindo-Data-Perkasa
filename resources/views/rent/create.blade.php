@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            {{-- header --}}
            <div class="page-header">
                <h4 class="page-title">Peminjaman Mobil</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('car.index') }}">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rent.index') }}">
                            Daftar Peminjaman Mobil
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            Form Pinjam Mobil
                        </a>
                    </li>
                </ul>
            </div>

            {{-- main content --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Peminjaman Mobil</div>
                            <div class="card-category">
                                Form ini digunakan untuk meminjam mobil pada perpustakaan SMK Negeri 1 Sungai Menang
                            </div>
                        </div>
                        <form id="formAddRent" method="POST">
                            @csrf
                            <div class="card-body">
                                {{-- car id --}}
                                <div class="form-group form-show-validation row select2-form-input">
                                    <label for="car_id" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Mobil
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <div class="select2-input">
                                            <select class="form-control" id="carId" name="car_id" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- start_date --}}
                                <div class="form-group form-show-validation row">
                                    <label for="start_date" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Tanggal
                                        Mulai Pinjam
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <input type="text" class="form-control" id="start_date" name="start_date"
                                            placeholder="Masukkan Tanggal Mulai Pinjam" required>
                                    </div>
                                </div>
                                {{-- end_date --}}
                                <div class="form-group form-show-validation row">
                                    <label for="end_date" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Tanggal
                                        Batas Pinjam
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <input type="text" class="form-control" id="end_date" name="end_date"
                                            placeholder="Masukkan Tanggal Batas Pinjam" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <a href="{{ route('car.index') }}" class="btn btn-default btn-outline-dark"
                                            role="presentation">Batal</a>
                                        <button class="btn btn-primary ml-3" id="formAddRentButton"
                                            type="submit">Kirim</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
        integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            getCarData();
            // getStudentData();
            $('#carId').select2({
                theme: "bootstrap",
            });
            $('#student_id').select2({
                theme: "bootstrap"
            });
            var today = moment().format('YYYY/MM/DD');;
            $('#start_date').datetimepicker({
                format: 'DD/MM/YYYY',
                defaultDate: today
            });
            $('#end_date').datetimepicker({
                format: 'DD/MM/YYYY',
            });
        });

        function getCarData() {
            var htmlstring = '<option value="">Pilih Mobil</option>';
            $.ajax({
                type: "GET",
                url: `{{ route('car.data') }}`,
                dataType: "json",
                success: function(response) {
                    $.each(response.data.cars, function(index, item) {
                        htmlstring += `<option value="${item.id}">${item.name}</option>`;
                    });
                    $('#carId').html(htmlstring);
                },
                error: function(xhr, status, error) {
                    swal({
                        title: "Gagal!",
                        text: "Terjadi kegagalan, silahkan coba beberapa saat lagi! Error: " + error,
                        icon: "error",
                    });
                    return false;
                },
            });
        }

        $("#formAddRent").validate({
            rules: {
                car_id: {
                    required: true,
                },
                start_date: {
                    required: true,
                },
                end_date: {
                    required: true,
                },
            },
            messages: {
                car_id: {
                    required: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>ID Mobil tidak boleh kosong',
                },
                start_date: {
                    required: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Tanggal Mulai Pinjam tidak boleh kosong',
                },
                end_date: {
                    required: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Tanggal Batas Pinjam tidak boleh kosong',
                },
            },
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                $('#formAddRentButton').html('<i class="fas fa-circle-notch text-lg spinners-2"></i>');
                $('#formAddRentButton').prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: `{{ route('rent.store') }}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        car_id: $('#carId').val(),
                        start_date: moment($('#start_date').val(), 'DD/MM/YYYY').format('YYYY/MM/DD'),
                        end_date: moment($('#end_date').val(), 'DD/MM/YYYY').format('YYYY/MM/DD'),
                    },
                    success: function(response) {
                        $('#formAddRentButton').html('Kirim');
                        $('#formAddRentButton').prop('disabled', false);
                        swal({
                                title: "Berhasil!",
                                text: response.meta.message,
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        text: "Okay",
                                        value: "confirm",
                                        visible: true,
                                        className: "btn btn-success",
                                        closeModal: true,
                                    }
                                }
                            })
                            .then((value) => {
                                if (value === "confirm") {
                                    window.location.href = response.data.redirect
                                }
                            });

                        setTimeout(function() {
                            window.location.href = response.data.redirect
                        }, 4000);
                    },
                    error: function(xhr, status, error) {
                        $('#formAddRentButton').html('Kirim');
                        $('#formAddRentButton').prop('disabled', false);
                        if (xhr.responseJSON) {
                            swal({
                                title: "Gagal!",
                                text: xhr.responseJSON.meta.message + " Error : " + xhr
                                    .responseJSON.data.error,
                                icon: "error",
                            });
                        } else {
                            swal({
                                title: "Gagal!",
                                text: "Terjadi kegagalan, silahkan coba beberapa saat lagi! Error: ",
                                error,
                                icon: "error",
                            });
                        }
                        return false;
                    },
                });
            }
        });
    </script>
@endsection
