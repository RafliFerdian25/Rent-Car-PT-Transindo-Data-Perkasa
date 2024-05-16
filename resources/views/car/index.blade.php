@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            {{-- header --}}
            <div class="page-header">
                <h4 class="page-title">Mobil Rental</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('rent.index') }}">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            Data Mobil Rental
                        </a>
                    </li>
                </ul>
            </div>

            {{-- main content --}}
            {{-- Filter  --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Tambah Mobil</div>
                            <div class="card-category">
                                Form ini digunakan untuk menambah Mobil
                            </div>
                        </div>
                        <form id="formFilterCar">
                            @csrf
                            <div class="card-body">
                                {{-- Merek --}}
                                <div class="form-group form-show-validation row">
                                    <label for="brand_id" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Merek
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <select class="form-control" id="filterBrand" name="brand_id">
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
                                        <select class="form-control" id="filterCarType" name="car_type_id">
                                            <option value="">Pilih Model</option>
                                            @foreach ($carTypes as $carType)
                                                <option value="{{ $carType->id }}">{{ $carType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Tarif sewa --}}
                                {{-- <div class="form-group form-show-validation row">
                                    <label for="rental_rate" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Tarif
                                        Sewa
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <input type="number" class="form-control" id="rental_rate" name="rental_rate"
                                            placeholder="Masukkan Tarif Sewa" required>
                                    </div>
                                </div> --}}
                                {{-- Tanggal Mulai --}}
                                <div class="form-group form-show-validation row">
                                    <label for="start_date" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Tanggal
                                        Mulai
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <input type="date" class="form-control" id="filterStartDate" name="start_date"
                                            placeholder="Masukkan Tanggal Mulai">
                                    </div>
                                </div>
                                {{-- Tanggal Selesai --}}
                                <div class="form-group form-show-validation row">
                                    <label for="end_date" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-sm-right">Tanggal
                                        Selesai
                                        <span class="required-label">*</span></label>
                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                        <input type="date" class="form-control" id="filterEndDate" name="end_date"
                                            placeholder="Masukkan Tanggal Selesai">
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-primary ml-3" id="formFilterCarButton" type="button"
                                            onclick="getCars()">Kirim</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Daftar Mobil --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Data Mobil Rental</div>
                                @if (Auth::user()->role == 'admin')
                                    <div class="card-tools">
                                        <a href="{{ route('car.create') }}"
                                            class="btn btn-info btn-border btn-round btn-sm mr-2">
                                            <span class="btn-label">
                                            </span>
                                            Tambah Mobil
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive pb-4">
                                <table id="carTable" class="display table table-striped table-hover">
                                    <thead>
                                        <tr class="space-nowrap">
                                            <th class="text-center">#</th>
                                            <th class="text-center">Nama</th>
                                            <th class="">Merk</th>
                                            <th class="">Model</th>
                                            <th class="">Tarif Sewa (hari)</th>
                                            <th class="filter-none">Plat Nomer</th>
                                            <th class="text-center filter-none text-nowrap">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="carTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const carTable = $('#carTable').DataTable({
            columnDefs: [{
                targets: 'filter-none',
                orderable: false,
            }, {
                // Mengatur aturan pengurutan kustom untuk kolom keempat (index 3)
                "targets": [4],
                "render": function(data, type, row) {
                    // Memeriksa tipe data, jika tampilan atau filter
                    if (type === 'display' || type === 'filter') {
                        // Memformat angka menggunakan fungsi formatCurrency
                        return formatCurrency(data);
                    }
                    // Jika tipe data selain tampilan atau filter, kembalikan data tanpa perubahan
                    return data;
                }
            }, ],
            language: {
                "sEmptyTable": "Tidak ada data yang tersedia di tabel",
                "sInfo": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                "sInfoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari total _MAX_ entri)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "Tampilkan _MENU_ entri",
                "sLoadingRecords": "Memuat...",
                "sProcessing": "Memproses...",
                "sSearch": "Cari:",
                "sSearchPlaceholder": "Masukkan Keyword...",
                "sZeroRecords": "Tidak ditemukan data yang cocok",
                "oPaginate": {
                    "sFirst": "Pertama",
                    "sLast": "Terakhir",
                    "sNext": "Berikutnya",
                    "sPrevious": "Sebelumnya"
                },
                "oAria": {
                    "sSortAscending": ": aktifkan untuk mengurutkan kolom secara naik",
                    "sSortDescending": ": aktifkan untuk mengurutkan kolom secara menurun"
                },
                "select": {
                    "rows": {
                        "_": "Terpilih %d baris",
                        "0": "Klik sebuah baris untuk memilih",
                        "1": "Terpilih 1 baris"
                    }
                },
                "buttons": {
                    "print": "Cetak",
                    "copy": "Salin",
                    "copyTitle": "Salin ke papan klip",
                    "copySuccess": {
                        "_": "%d baris disalin",
                        "1": "1 baris disalin"
                    }
                },
            },
            lengthMenu: [5, 10, 25, 50, 100],
            pageLength: 10, // default page length
            dom: "<'row pb-0 py-2'<'col-sm-12 col-xl-4'l><'col-sm-12 col-xl-8 carTable_category_wrapper'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row pt-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        });

        $(document).ready(function() {
            getCars();
        });

        const showLoadingIndicator = () => {
            $('#carTableBody').html(tableLoader(11, `{{ asset('assets/img/loader/Ellipsis-2s-48px.svg') }}`));
        }

        function getCars() {
            carTable.clear().draw();
            showLoadingIndicator();

            $('#formFilterCarButton').html('<i class="fas fa-circle-notch text-lg spinners-2"></i>');
            $('#formFilterCarButton').prop('disabled', true);
            $.ajax({
                type: "GET",
                url: "{{ route('car.data') }}",
                data: {
                    token: "{{ csrf_token() }}",
                    filterCarType: $('#filterCarType').val(),
                    filterBrand: $('#filterBrand').val(),
                    filterStartDate: $('#filterStartDate').val(),
                    filterEndDate: $('#filterEndDate').val(),
                },
                dataType: "json",
                success: function(response) {
                    var userRole = "{{ Auth::user()->role }}";
                    if (response.data.cars.length > 0) {
                        $.each(response.data.cars, function(index, car) {
                            var rowData = [
                                index + 1,
                                car.name,
                                car.brand.name,
                                car.car_type.name,
                                car.rental_rate,
                                car.license_plate,
                                userRole == 'admin' ? `
                                <a href="{{ url('car/${car.id}/edit') }}" class="btn btn-primary btn-sm mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteCar('${car.id}')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                                ` : `<a href="{{ route('rent.create') }}" class="btn btn-primary btn-sm mr-2">
                                    Pinjam
                                </a>`,
                            ];
                            var rowNode = carTable.row.add(rowData).draw(
                                    false)
                                .node();

                            $(rowNode).find('td').eq(0).addClass('text-center');
                            $(rowNode).find('td').eq(1).addClass('text-center');
                            $(rowNode).find('td').eq(3).addClass('text-nowrap');
                            $(rowNode).find('td').eq(8).addClass('text-center');
                            $(rowNode).find('td').eq(9).addClass('text-center');
                            $(rowNode).find('td').eq(10).addClass('text-center text-nowrap');
                        });
                    } else {
                        $('#carTableBody').html(tableEmpty(11, 'Mobil Rental'));
                    }

                    $('#formFilterCarButton').html('Kirim');
                    $('#formFilterCarButton').prop('disabled', false);
                },
                error: function(response) {
                    $('#carTableBody').html(tableError(11, `${response.responseJSON.data.error}`));

                    $('#formFilterCarButton').html('Kirim');
                    $('#formFilterCarButton').prop('disabled', false);
                }
            });
        }

        $("#carTable_category_select").on('change', function() {
            getCars();
        });

        function deleteCar(id) {
            swal({
                dangerMode: true,
                title: "Apakah anda yakin?",
                text: "Data Mobil akan dihapus!",
                icon: "warning",
                buttons: ["Batal", "Hapus"],
            }).then((result) => {
                if (result) {
                    $.ajax({
                        type: "DELETE",
                        url: `{{ url('/car/${id}') }}`,
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            swal({
                                    title: "Berhasil!",
                                    text: response.meta.message,
                                    icon: "success",
                                    buttons: {
                                        ok: "OK",
                                    },
                                })
                                .then(() => {
                                    getCars();
                                });
                        },
                        error: function(xhr, status, error) {
                            if (xhr.responseJSON) {
                                swal({
                                    title: "Gagal!",
                                    text: xhr.statusText + ", Error : " + xhr
                                        .responseJSON.message,
                                    icon: "error",
                                });
                            } else {
                                swal({
                                    title: "Gagal!",
                                    text: "Terjadi kegagalan, silahkan coba beberapa saat lagi! Error: " +
                                        error,
                                    icon: "error",
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
