@extends('partials.linkrel')
@include('partials.navbar')

<div id="cart-add-success" class="fixed-top mt-5 alert alert-success text-center" role="alert">
   
</div>

<div id="alert-stok" class="fixed-top mt-5 alert alert-danger text-center" role="alert">
   
</div>

<div id="delete-wishlist-success" class="fixed-top mt-5 alert alert-warning text-center" role="alert">
    Berhasil menghapus produk dari Wishlist
</div>

<div id="add-wishlist-success" class="fixed-top mt-5 alert alert-warning text-center" role="alert">
    Berhasil menambahkan produk ke Wishlist
</div>

<div class="container mt-4">
    @yield('container')

    <form method="post">
        @csrf
                <div class="text-center">
                <input id="url_gambar" type="hidden" name="nama_produk" value="{{$produk->url_gambar}}">
                <img style="width: 300px; height:300px;" class="thumbnail" src="{{$produk->url_gambar}}">
                <br><br>
                <h4 class="title text-dark">
                    <input id="nama_produk" type="hidden" name="nama_produk" value="{{$produk->nama_produk}}">
                {{$produk->nama_produk}}
                  </h4>
                </div>
                  <p style="font-weight: 100;">
                    {{$produk->kegunaan}}
                  </p>
                  <input id="stok" type="hidden" name="stok" value="{{$produk->stok}}">    
                  Stok : {{$produk->stok}}<br>
                  <input id="harga" type="hidden" name="nama_produk" value="{{$produk->harga}}">
                  <input id="berat" type="hidden" name="nama_produk" value="{{$produk->berat}}">
                  Harga : Rp. {{number_format($produk->harga,0,',','.')}}<br><br>
                <input class="qty" id="qty" style="width: 50px; text-align:center" type="number" 
                name="qty" value="1" max="{{$produk->stok}}" min="1"><br><br>

                <div style="display: flex;" class="text-center">
                    <button style="display: flex; align-items:center;" id="cart-add" class="btn btn-success" data-dismiss="alert" type="submit">
                        TAMBAH KE KERANJANG
                    </button>&nbsp;
                
                    @if (DB::collection('wishlist')->where('nama_produk', $produk->nama_produk)
                    ->where('username', auth()->user()->username)->exists())
                    
                    <button style="display: flex; align-items:center;" id="delete-wishlist" class="btn btn-danger">
                        HAPUS DARI WISHLIST
                    </button>
                    
                    @else
                        <button style="align-items:center; font-weight:500;" id="add-wishlist" class="btn btn-warning">
                            WISHLIST
                        </button>
                        
                    @endif
                    
                </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        // if(localStorage.getItem("cart-addClicked"))
        // {      
        //     localStorage.removeItem("cart-addClicked");     
        //     $('#cart-add-success').slideDown(150);
        //     setTimeout(function() {
        //         $('#cart-add-success').slideUp(900);
        //         }, 5000);
        // }

        if(localStorage.getItem("add-wishlistClicked"))
        {      
            localStorage.removeItem("add-wishlistClicked");     
            $('#add-wishlist-success').slideDown(150);
            setTimeout(function() {
                $('#add-wishlist-success').slideUp(900);
                }, 5000);
        }

        if(localStorage.getItem("delete-wishlistClicked"))
        {      
            localStorage.removeItem("delete-wishlistClicked");     
            $('#delete-wishlist-success').slideDown(150);
            setTimeout(function() {
                $('#delete-wishlist-success').slideUp(900);
                }, 5000);
        }


        $('#qty').on('change', function() {
            var maxValue = parseInt($('#qty').attr('max'));
            if ($('#qty').val() < 1)
            {
            alert('MINIMAL 1');
            $("#qty").val('1');
            } else if ($('#qty').val() > maxValue)
            {
            alert('MAKSIMAL ' + maxValue);
            $("#qty").val(maxValue);
            }
        });

        $('#cart-add').on('click', function(e) {
                e.preventDefault();
                $('#cart-add-success').hide();
                $('#cart-add-success').html('');
                $('#alert-stok').html('');

                let nama_produk = $('#nama_produk').val(); 
                let url_gambar = $('#url_gambar').val();
                let harga = $('#harga').val();
                let berat = $('#berat').val();
                let stok = $('#stok').val();
                let qty = $('#qty').val();
            $.ajax({
                url: "{{ route('beli.keranjang') }}",
                type: 'POST',
                dataType: 'text',
                data: 
                {
                    _token: "{{ csrf_token() }}",
                    nama_produk: nama_produk,
                    url_gambar: url_gambar,
                    harga: harga,
                    berat: berat,
                    stok: stok,
                    qty: qty
                },
                success: function(){
                    $('#cart-add-success').append(
                        `
                        Berhasil Menambahkan (${qty} item) ke Keranjang
                        <a class="ml-2" href="/keranjang">
                            <b>Cek Keranjang</b>
                        </a>
                        `    
                        );
                        $('#cart-add-success').slideDown(150);
                    
                },
                error: function(xhr, status, error) {
                    $('#alert-stok').append(
                    `
                        Pembelian melebihi stok (maks. {{$produk->stok}})
                    `    
                    );
                    $('#alert-stok').slideDown(150);
                }
            });
            setTimeout(function() {
                $('#cart-add-success').slideUp(900);
                }, 5000);
            setTimeout(function() {
                $('#alert-stok').slideUp(900);
                }, 2000);
        });

        $('#add-wishlist').on('click', function(e) {
            e.preventDefault();
            $('#add-wishlist-success').hide();
            let nama_produk = $('#nama_produk').val(); 
            let url_gambar = $('#url_gambar').val();

            $.ajax({
                url: "beli/wishlist",
                type: 'POST',
                dataType: 'text',
                data: 
                {
                    _token: "{{ csrf_token() }}",
                    nama_produk: nama_produk,
                    url_gambar: url_gambar
                },
                success: function(){
                    location.reload(); 
                    localStorage.setItem("add-wishlistClicked", true);
                }
            });
        });

        $('#delete-wishlist').on('click', function(e) {
            e.preventDefault();
            $('#delete-wishlist-success').hide();
            let nama_produk = $('#nama_produk').val(); 

            $.ajax({
                url: "delete/wishlist",
                type: 'DELETE',
                dataType: 'text',
                data: 
                {
                    _token: "{{ csrf_token() }}",
                    nama_produk: nama_produk
                },
                success: function(){
                    location.reload(); 
                    localStorage.setItem("delete-wishlistClicked", true);
                }
            });
        });
});
</script>
 <body>
</html>

