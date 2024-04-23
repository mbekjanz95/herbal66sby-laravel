@extends('partials.linkrel')
@include('partials.navbar')

<h1> -- DAFTAR PRODUK --</h1>

<div class="container">
    <div class="row">
        @foreach ($data as $row )
            <div class="mt-5 col-12 col-md-6 col-lg-4">   
                <div class="card" style="width: 18rem;">
                <a href="{{$row->nama_produk}}">
                    <img class="card-img-top" src="{{$row->url_gambar}}" alt="Card image cap">
                    <div class="card-body">
                    <h3 class="card-title">{{$row->nama_produk}}</h3>
                        <p class="card-text text-truncate">{{$row->kegunaan}}</p>
                    <h5 class="card-title">Rp. {{$row->harga}}</h5>
                    </div>
                </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pagination justify-content-center">{{$data->links()}}</div>
</div>

</body>
</html>