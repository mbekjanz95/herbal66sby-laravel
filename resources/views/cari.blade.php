@extends('partials.linkrel')
@include('partials.navbar')

<div class="container mt-4">
    @yield('container')
</div>
<div style="color: red;" class="keterangan">Geser tabel ke kanan (->) untuk informasi lebih lengkap</div> 
    @forelse ($hasil as $row)
        <div class="mt-4 table-responsive">
            <a href="{{$row->nama_produk}}">
            <table class="table table-bordered" style="border-width:8px;">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col"></th>  
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Kegunaan</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td><img class="thumbnail" src="{{$row->url_gambar}}" style="height: 100px;width: 100px;"></td>  
                    <td>{{$row->nama_produk}}</td>
                    <td><p style="text-align: justify;">{{$row->kegunaan}}</p></td>
                    <td>{{$row->stok}}</td>
                    <td>{{$row->harga}}</td>
                    </tr>
                </tbody>
            </table>
            </a>
        </div>
    @empty
        <h1 style="text-align: center;">Nama Produk atau jenis keluhan tidak ditemukan !</h1>
    @endforelse
</body>
</html>
