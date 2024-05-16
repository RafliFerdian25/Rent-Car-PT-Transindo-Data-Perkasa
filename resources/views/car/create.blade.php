@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            {{-- header --}}
            <div class="page-header">
                <h4 class="page-title">Tambah Mobil</h4>
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
                        <a href="#">
                            Form Tambah Mobil
                        </a>
                    </li>
                </ul>
            </div>

            {{-- main content --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Tambah Mobil</div>
                            <div class="card-category">
                                Form ini digunakan untuk menambah Mobil
                            </div>
                        </div>
                        <form id="formAddCar" method="POST">
                            @csrf
                            <div class="card-body">
                                {{-- Nama --}}
                                <div class="form-group form-show-validation row">
                                    <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Nama
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Masukkan Nama Mobil" required>
                                    </div>
                                </div>
                                {{-- Merek --}}
                                <div class="form-group form-show-validation row">
                                    <label for="brand_id" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Merek
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <select class="form-control" id="brand_id" name="brand_id" required>
                                            <option value="">Pilih Merek</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Model --}}
                                <div class="form-group form-show-validation row">
                                    <label for="car_type_id" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Model
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8 select2-input select2-info">
                                        <select class="form-control" id="car_type_id" name="car_type_id" required>
                                            <option value="">Pilih Model</option>
                                            @foreach ($carTypes as $carType)
                                                <option value="{{ $carType->id }}">{{ $carType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Tarif sewa --}}
                                <div class="form-group form-show-validation row">
                                    <label for="rental_rate" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Tarif
                                        Sewa
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <input type="number" class="form-control" id="rental_rate" name="rental_rate"
                                            placeholder="Masukkan Tarif Sewa" required>
                                    </div>
                                </div>
                                {{-- Nomer Plat --}}
                                <div class="form-group form-show-validation row">
                                    <label for="license_plate"
                                        class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Nomer
                                        Plat
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <input type="text" class="form-control" id="license_plate" name="license_plate"
                                            placeholder="Masukkan Nomer Plat" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <a href="{{ route('car.index') }}" id="backToCar"
                                            class="btn btn-default btn-outline-dark" role="presentation">Batal</a>
                                        <button class="btn btn-primary ml-3" id="formAddCarButton"
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
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
        integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script>
        // Menambahkan aturan validasi kustom untuk ukuran maksimum file
        $.validator.addMethod('maxfilesize', function(value, element, param) {
            var maxSize = param;

            if (element.files.length > 0) {
                var fileSize = element.files[0].size; // Ukuran file dalam byte
                return fileSize <= maxSize;
            }

            return true;
        }, '');
        $(document).ready(function() {
            // $("#brand_id").select2({
            //     placeholder: "Pilih Merek",
            //     allowClear: true
            // });
            // $("#car_type_id").select2({
            //     placeholder: "Pilih Model",
            //     allowClear: true
            // });
        });

        $("#formAddCar").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                },
                brand_id: {
                    required: true,
                },
                car_type_id: {
                    required: true,
                },
                rental_rate: {
                    required: true,
                    min: 0,
                    number: true,
                },
                license_plate: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Nama Mobil tidak boleh kosong',
                    minlength: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Nama Mobil harus 3 karakter',
                },
                brand_id: {
                    required: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Merek Mobil tidak boleh kosong',
                },
                car_type_id: {
                    required: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Model Mobil tidak boleh kosong',
                },
                rental_rate: {
                    required: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Tarif Sewa tidak boleh kosong',
                    min: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Tarif Sewa tidak boleh kurang dari 0',
                    number: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Tarif Sewa harus berupa angka',
                },
                license_plate: {
                    required: '<i class="fas fa-exclamation-circle mr-6 text-sm icon-error"></i>Nomer Plat tidak boleh kosong',
                },
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                var formData = new FormData(form);
                $('#formAddCarButton').html('<i class="fas fa-circle-notch text-lg spinners-2"></i>');
                $('#formAddCarButton').prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: `{{ route('car.store') }}`,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#formAddCarButton').html('Kirim');
                        $('#formAddCarButton').prop('disabled', false);
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
                            .then(() => {
                                window.location.href = response.data.redirect
                            });

                        setTimeout(function() {
                            window.location.href = response.data.redirect
                        }, 4000);
                    },
                    error: function(xhr, status, error) {
                        $('#formAddCarButton').html('Kirim');
                        $('#formAddCarButton').prop('disabled', false);
                        if (xhr.responseJSON) {
                            new swal({
                                title: "Gagal!",
                                text: xhr.statusText + ", Error : " + xhr
                                    .responseJSON.message,
                                icon: "error",
                            });
                        } else {
                            new swal({
                                title: "Gagal!",
                                text: "Terjadi kegagalan, silahkan coba beberapa saat lagi! Error: " +
                                    xhr.statusText,
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
