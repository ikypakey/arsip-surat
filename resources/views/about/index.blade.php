<?php
?>
@extends('layouts.main')
@section('title')
{{ 'About' }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title fw-semibold" style="margin-bottom: 20px">About</h4>
                <div class="about-section">
                    <img src="{{ asset('dashboard-assets/assets/img/pics.PNG') }}" alt="Deskripsi Gambar"
                        class="about-image">
                    <div class="about-description">
                        <h5>
                            Aplikasi ini dibuat oleh :
                        </h5>
                        <table class="info-table">
                            <tr>
                                <td>Nama</td>
                                <td style="width: 1%">:</td>
                                <td>Muhammad Rizki Mubarok</td>
                            </tr>
                            <tr>
                                <td>Prodi</td>
                                <td style="width: 5%">:</td>
                                <td>D-IV Teknik Informatika</td>
                            </tr>
                            <tr>
                                <td>NIM</td>
                                <td style="width: 5%">:</td>
                                <td>2041720001</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td style="width: 5%">:</td>
                                <td>10 Juli 2024</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        @endsection
        <style>
            .about-section {
                display: flex;
                align-items: center;
            }

            .about-image {
                width: 280px;
                /* Sesuaikan ukuran gambar */
                height: 300px;
                margin-right: 20px;
                margin-left: auto;
                border-radius: 20px
            }

            .about-description {
                flex: 1;
                margin-bottom: 100px
            }

            .info-table {
                width: 100%;
                margin-left: -10px;
                border-collapse: collapse;
            }

            .info-table td {
                padding: 5px 10px;
                vertical-align: top;
            }

            .info-table td:first-child {
                font-weight: bold;
                width: 150px;
                /* Sesuaikan lebar kolom pertama */
            }
        </style>