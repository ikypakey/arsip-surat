@extends('layouts.main')
@section('content')
<style>
    .card:hover {
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        transition: box-shadow 0.3s ease-in-out;
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
       <div class="col-lg-13 mb-4 order-0">
            <div class="card mt-2composer require yajra/laravel-datatables-oracle" style="height: 90%;">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-9">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between"
                                style="margin-bottom: 0%">
                                <h3 class="card-title text-dark mt-0 mb-3" style="font-weight: bold;">Sistem Informasi Manajemen Arsip Surat</h3>
                            </div>
                            <h6 style="margin-top: px;">Welcome Back to The Dashboard</h6s>
                        </div>
                    </div>
                    <div class="col-sm-3 text-end">
                        <div class="card-body pb-0 px-0 px-md-0">
                            <img src="{{ asset('admin/assets/img/illustrations/man-with-laptop-light.png') }}" height="86" class="mb-2"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    

        <!--/ Transactions -->
    </div>
</div>
<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/highcharts.js') }}"></script>
<script src="{{ asset('admin/assets/js/exporting.js') }}"></script>
<script src="{{ asset('admin/assets/js/export-data.js') }}"></script>
<script src="{{ asset('admin/assets/js/accessibility.js') }}"></script>

@endsection