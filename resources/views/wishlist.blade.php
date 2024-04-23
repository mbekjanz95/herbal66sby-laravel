@extends('partials.linkrel')
@include('partials.navbar')

<div class="container mt-4">
    <div class = "card bg-warning">
        <div class = "card-header">
           <h3 class = "text-white card-title">Wishlist</h3>
        </div>
        <div class = "bg-light card-body">
            <span id="kosong">
            @if ($wishlist->count() == 0)
                <h1 class="text-center">Belum ada produk di Wishlist</h1>
            </span>
            @else
                <div class="container">
                    <div class="row">
                        @foreach ($wishlist as $row )
                        <div class="mt-5 col-12 col-md-6 col-lg-4">   
                            <div class="card" style="width: 18rem;">
                            <a href="{{$row->nama_produk}}">
                                <img class="card-img-top" src="{{$row->url_gambar}}" alt="Card image cap">
                                <div class="card-body">
                                <h5 class="card-title">{{$row->nama_produk}}</h5>
                                </div>
                            </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
</div>
</div>
</div>
</body>
</html>