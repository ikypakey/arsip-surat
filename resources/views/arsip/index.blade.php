@extends('layouts.main')
@section('title')
{{ 'Details ' }}
@endsection
@section('content')
<link rel="stylesheet" href="{{ asset('admin/assets/datatable/css_jquery.dataTables.css') }}" />
<style>
    .pagination a {
        color: #0A4D68;
        /* Ubah warna tautan sesuai keinginan Anda */
    }

    /* Mengubah warna tautan pagination yang aktif */
    .pagination .page-item.active a {
        background-color: #0A4D68;
        /* Ubah warna latar belakang tautan yang aktif sesuai keinginan Anda */
        border-color: #0A4D68;
        /* Ubah warna border tautan yang aktif sesuai keinginan Anda */
        color: #0A4D68;
        /* Ubah warna teks tautan yang aktif sesuai keinginan Anda */
    }

    .pagination .page-item.active .page-link {
        background-color: #0A4D68;
        /* Ubah warna latar belakang sesuai keinginan Anda */
        border-color: #FF5733;
        /* Ubah warna border sesuai keinginan Anda */
        color: white;
        /* Ubah warna teks sesuai keinginan Anda */
    }

    /* Add this CSS to make the table header sticky */
    .sticky {
        position: sticky;
        top: 0;
        z-index: 999;
    }

    thead {
        position: sticky;
        top: 0;
        z-index: 1;
    }


    /* Mengubah warna garis tengah di antara baris pada tabel */


    /* Add this CSS to change the primary button color to #CC99FF */
    .btn-primary {

        /* You can also adjust other properties like text color and border if needed */
        color: white;
        /* Set text color to white for better visibility */
        border-color: #0A4D68;
        /* Set border color to match the background color */
    }


    .dataTables_filter {
        margin-bottom: 5px;
    }

    /* Mengatur ukuran dan warna teks pada label */
    label {
        font-size: 14px;
        color: #333;
        font-weight: bold;
    }

    /* Mengatur tampilan input search */
    input[type="search"] {
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 5px 10px;
        font-size: 12px;

    }

    .spinner-overlay {
        position: fixed;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 100;
        /* Ensure the spinner appears on top of everything */
    }

    .btn-orange-moon {
        background: #fc4a1a;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #f7b733, #fc4a1a);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #f7b733, #fc4a1a);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        color: #fff;
        border: 3px solid #eee;
    }

    .btn-ultra-voilet {
        background: #654ea3;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #eaafc8, #654ea3);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #eaafc8, #654ea3);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        color: #fff;
        border: 3px solid #eee;
    }

    /* Center the spinner horizontally and vertically */
    .spinner-overlay .spinner-border {
        margin: 0;
    }

    .table td {
        font-size: 16px;
        /* Ubah ukuran font sesuai keinginan Anda */
        color: #0A4D68;
        /* Ubah warna teks sesuai keinginan Anda */
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif
            /* Ubah jenis font sesuai keinginan Anda */
            /* Ubah ketebalan teks sesuai keinginan Anda */
    }



    /* Memberikan padding pada elemen .dataTables_filter untuk memperbaiki tata letak */
</style>
<div id="spinner" class="spinner-overlay text-primary" style="display: none;">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
@if ($errors->has('kategori'))
<div id="alertWarning" class="alert alert-danger">
    {{ $errors->first('kategori') }}
</div>
@endif
<div class="container-fluid">
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title fw-semibold " style="margin-bottom: 20px;">Arsip Surat</h4>
            <h6 class="fw-semibold " style="margin-bottom: -15px;">Berikut ini adalah surat-surat yang telah terbit dan diarsipkan. Klik 'Lihat' pada kolom action untuk menampilkan</h6>
            {{-- modal add --}}
            <div class="modal fade" id="ModalAdd" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Add</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('archive.store') }}" method="POST" enctype="multipart/form-data"
                                onsubmit="return validateForm()">
                                @csrf
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Nomor Surat</label>
                                    <input type="text" class="form-control" id="category_name" name="number" required>
                                </div>
                                <div class="mb-3">
                                    <label for="select" class="form-label">Kategori</label>
                                    <select class="form-select" id="select" name="kategori_id" required>
                                        @foreach ($kategori as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="details" class="form-label">Judul</label>
                                    <input type="text" class="form-control" id="category_name" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="details" class="form-label">File</label>
                                    <input type="file" class="form-control" id="category_name" name="file" required
                                        accept="application/pdf">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-secondary" style="background-color: #8b6cfa;"
                                        id="saveChangesBtn">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal end --}}
        <div class="card-body">
            <div class="col-auto d-flex justify-content-start">
                <a href="" class="btn btn-primary " data-bs-toggle="modal"
                    style=" margin-bottom: 3px; margin: left 10px;" data-bs-target="#ModalAdd"><i
                        class="bx bx-add-to-queue me-1"></i>Arsipkan Surat</a>
            </div>
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                   
            </div>
            @endif
            {{-- TABELSO --}}
            <div class="table-responsive text-nowrap table-container" style="margin: bottom 20px;">
                <table class="table custom-table mt-4   " id="tabels"
                    style="border-top:1px solid #86C8BC; border-bottom: 1px solid #86C8BC; margin-bottom: 5px; ">
                    <thead class=""
                        style="border-top:1px solid #86C8BC; border-bottom: 1px solid #86C8BC; margin: bottom 20px; border-color: #86C8BC ">
                        <tr>
                            <th
                                style="background-color: #D0F288; color: white; font-size: 13px;text-align:center; border-left: 1px solid #86C8BC;">
                                <span style="color: #016A70">Nomor Surat
                            </th>
                            <th
                                style="background-color: #D0F288; color: white; font-size: 13px;text-align:center; border-left: 1px solid #86C8BC;">
                                <span style="color: #016A70">Kategori
                            </th>
                            <th
                                style="background-color: #F7E6AD; color: white; font-size: 13px;text-align:center; border-left: 1px solid #86C8BC; ">
                                <span style="color: #016A70">Judul
                            </th>
                            <th
                                style="background-color: #F7E6AD; color: white; font-size: 13px;text-align:center; border-left: 1px solid #86C8BC; ">
                                <span style="color: #016A70">Waktu Pengarsipan
                            </th>

                            <th
                                style="max-width: 50px; min-width: 50px; background-color: #C1D0B5; color: white; font-size: 13px;text-align:center; border-right: 1px solid #86C8BC; border-left: 1px solid #86C8BC; ">
                                <span style="color: #016A70">ACTION
                            </th>
                            {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($archives as $kategori)
                        <tr style="padding: 5px;text-align: center; border-color:#86C8BC;  ">

                            <td
                                style="font-size: 18px;background-color: #F8FFD2; border-left: 1px solid #86C8BC;white-space:pre-line;  ">
                                {{ $kategori->number}}
                            </td>
                            <td
                                style="font-size: 18px; background-color: #FFFBDF; border-left: 1px solid #86C8BC; text-align: justify;;">
                                {{ $kategori->kategori->category_name }}
                            </td>
                            <td
                                style="font-size: 18px; background-color: #FFFBDF; border-left: 1px solid #86C8BC; text-align: justify;;">
                                {{ $kategori->title }}
                            </td>
                            <td style="font-size: 18px; background-color: #FFFBDF; border-left: 1px solid #86C8BC; text-align: justify;;">
                                {{ $kategori->created_at }}
                            </td>
                            <td
                                style="background-color:#D6E8DB; font-size: 12px; color: black; border-right: 1px solid #86C8BC; border-left: 1px solid #86C8BC; ">
                                <a class="btn btn-icon btn-primary" href="{{ route('archive.show', $kategori->id) }}"
                                    style="height: 30px; width: 30px; background-color: #35A29F;">
                                    <span class="tf-icons bx bx-show"></span>
                                </a>
                                <a class="btn btn-icon btn-secondary" href="{{ route('archive.download', $kategori->id) }}" style="height: 30px; width: 30px; background-color: #35A29F;"
                                    >
                                    <span class="tf-icons bx bx-download"></span> 
                                </a>
                                <button type="button" class="btn btn-icon btn-danger"
                                    style="height: 30px; width: 30px; background-color: #EB1D36 "
                                    onclick="event.preventDefault(); confirmDelete('{{ $kategori->id }}');">
                                    <span class="tf-icons bx bx-trash"></span>
                                </button>
                                <form id="delete-form-{{ $kategori->id }}"
                                    action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 20px;">
                    {{ $archives->links() }}
                </div>
                {{-- modal edit --}}
                @foreach ($archives as $kategori)
                <div class="modal fade" id="ModalEdit{{ $kategori->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Edit Item </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('archive.update', $kategori->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="category_name" class="form-label">Kategori</label>
                                        <textarea value="" type="text" class="form-control" id="category_name"
                                            name="category_name" required>{{ $kategori->category_name }}</textarea>
                                        <small class="form-text text-muted"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="details" class="form-label">Keterangan</label>
                                        <textarea value="{{ $kategori->details }}" type="text" class="form-control"
                                            id="details" name="details" required>{{ $kategori->details }}</textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-secondary"
                                            style="background-color: #8b6cfa;" id="saveChangesBtn">Save
                                            Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- modal end --}}
            </div>
            <!--/ Basic Bootstrap Table -->
        </div>
        <!-- Add CryptoJS from CDN -->
        <script src="{{ asset('admin/assets/datatable/cloudflare_ajax.min.js') }}"></script>
        <script src="{{ asset('admin/assets/datatable/jquery-3.7.0.js') }}"></script>
        <script src="{{ asset('admin/assets/datatable/jquery.dataTables.js') }}"></script>
        <script>
            //fungsi mengatur alert dan waktu muncul alert
            function showAlert() {
                var alert = document.getElementById("alertWarning");
                if (alert) {
                    alert.style.display = "block";

                    // Atur waktu muncul alert dalam detik
                    var displayTimeInSeconds = 5;

                    //Konversi waktu ke milidetik
                    var displayTimeInMillis = displayTimeInSeconds * 1000;

                    //Sembunyikan alert setelah waktu tertentu
                    setTimeout(function () {
                        alert.style.display = "none";
                    }, displayTimeInMillis);
                }
            }
            //panggil fungsi showAlert() untuk memanggil alert
            showAlert();

        </script>
        <script>
            let table = new DataTable('#tabels', {
                    dom: 'frt',
                    searching: true, // Menonaktifkan fitur pencarian\
                    paging: false, // Jenis pagination
                    ordering: false,
                    placeholder: "Search here...",
                },

            );

            function confirmDelete(timeId) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success m-1',
                        cancelButton: 'btn btn-danger m-1'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Yakin Untuk Hapus Data Ini?',
                    text: "Anda Tidak Dapat Mengembalikannya Setelah Dihapus",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Simulasi proses penghapusan dengan delay 0,5 detik
                        Swal.fire({
                            title: 'Menjalankan Proses Penghapusan',
                            icon: 'info',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                        setTimeout(() => {
                            document.getElementById('delete-form-' + timeId).submit();
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data Berhasil Dihapus',
                                icon: 'success',
                                showConfirmButton: false
                            });
                        }, 750);
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Dibatalkan',
                            'Perubahan Dibatalkan',
                            'error'
                        )
                    }
                })
            }

        </script>
        @endsection