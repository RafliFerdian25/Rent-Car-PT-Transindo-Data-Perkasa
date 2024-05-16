@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            {{-- header --}}
            <div class="page-header">
                <h4 class="page-title">Peminjaman</h4>
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
                            Data Peminjaman Mobil
                        </a>
                    </li>
                </ul>
            </div>

            {{-- main content --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Data Peminjaman Mobil</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive pb-4">
                                <table id="rentTable" class="display table table-striped table-hover">
                                    <thead>
                                        <tr class="space-nowrap">
                                            <th class="text-center">#</th>
                                            <th>Nama Mobil</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Batas Pinjam</th>
                                            <th>Status</th>
                                            <th>Bayar</th>
                                            <th class="text-center filter-none">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rentTableBody">
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
        $(document).ready(function() {
            getCars();
        });

        const rentTable = $('#rentTable').DataTable({
            columnDefs: [{
                    type: 'date-eu',
                    targets: 5
                },
                {
                    type: 'date-eu',
                    targets: 6
                }, {
                    targets: 'filter-none',
                    orderable: false,
                },
            ],
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
        });

        const showLoadingIndicator = () => {
            $('#rentTableBody').html(tableLoader(10, `{{ asset('assets/img/loader/Ellipsis-2s-48px.svg') }}`));
        }

        function getCars() {
            rentTable.clear().draw();
            showLoadingIndicator();

            $.ajax({
                type: "GET",
                url: "{{ route('rent.data') }}",
                success: function(response) {
                    if (response.data.rents.length > 0) {
                        $.each(response.data.rents, function(index, rent) {
                            ;
                            var rowData = [
                                index + 1,
                                rent.car.name,
                                rent.start_date,
                                rent.end_date,
                                rent.status,
                                rent.amount,
                                rent.status == 'kembali' ? '' : `
                                <button onclick="returnRent('${rent.id}')" class="btn btn-warning btn-sm">Pengembalian</button>
                                <button onclick="deleteRent('${rent.id}')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                                `
                            ];

                            var rowNode = rentTable.row.add(rowData)
                                .draw(
                                    false).node();

                            $(rowNode).find('td').eq(3).addClass('text-nowrap');
                        });
                    } else {
                        $('#rentTableBody').html(tableEmpty(10, 'mobil perpustakaan'));
                    }
                },
                error: function(response) {
                    $('#rentTableBody').html(tableError(10, `${response.responseJSON.message}`));
                }
            });
        }

        function deleteRent(id) {
            swal({
                dangerMode: true,
                title: "Apakah anda yakin?",
                text: "Data peminjaman akan dihapus!",
                icon: "warning",
                buttons: ["Batal", "Hapus"],
            }).then((result) => {
                if (result) {
                    $.ajax({
                        type: "DELETE",
                        url: `{{ url('/rent/${id}') }}`,
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
                                    text: xhr.responseJSON.meta.message + ", Error : " + xhr
                                        .responseJSON.data.error,
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

        function returnRent(id) {
            swal({
                dangerMode: true,
                title: "Apakah anda yakin?",
                text: "Data peminjaman akan dikembalikan!",
                icon: "warning",
                buttons: ["Batal", "Kembalikan"],
            }).then((result) => {
                if (result) {
                    $.ajax({
                        type: "POST",
                        url: `{{ url('/rent/${id}/return') }}`,
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
                                    text: xhr.responseJSON.meta.message + ", Error : " + xhr
                                        .responseJSON.data.error,
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
