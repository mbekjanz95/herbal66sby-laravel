@extends('partials.linkrel')
@include('partials.navbar')

<div id="sukses" class="fixed-top mt-5 alert alert-success text-center" role="alert">
  Berhasil menghapus produk dari keranjang
</div> 

<div class="container mt-4">
  <div class = "card bg-success">
      <div class = "card-header">
        @if ($keranjang->count() == 0)

        @else
          <h3 class = "text-white card-title">Keranjang ({{$total_produk}} produk)<br>
              @php
                $grand_total = 0;
              @endphp
            @foreach ($keranjang as $row)
              @php
                $sub_total= $row->harga * $row->qty;
                $grand_total += $sub_total;
              @endphp
            @endforeach
            Total : <span class="total-bayar">Rp. {{number_format($grand_total,0,',','.')}}</span>
          </h3>
        @endif
      </div>
    
      <div class = "bg-light card-body">
        <span id="kosong">
          @if ($keranjang->count() == 0)
            <h1 class="text-center">Tidak ada produk di keranjang</h1>
        </span>
          @else
        <div style="color: red;" class="keterangan">Geser tabel ke kanan (->) untuk mengatur jumlah pembelian</div> 
            @php
                $grand_total = 0;
            @endphp

          @foreach ($keranjang as $row)
            @php
                $sub_total= $row->harga * $row->qty;
                $grand_total += $sub_total;
            @endphp
            <div class="mt-4 table-responsive">
              <table class="table table-bordered" style="border-width:8px;">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col"></th>
                      <th scope="col"></th>
                      <th scope="col">Nama Produk</th>
                      <th scope="col">Harga @</th>
                      <th scope="col">Qty</th>
                      <th scope="col">Berat @</th>
                      <th scope="col">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><button class="btn-hapus">Hapus dari Keranjang</button></td>
                      <td><img src="{{$row->url_gambar}}" class="thumbnail"></td>
                      <td>
                        <input type="hidden" class="nama_produk" value="{{$row->nama_produk}}">
                        {{$row->nama_produk}}
                      </td>
                      <td>
                        <input type="hidden" class="harga" value="{{$row->harga}}">
                        Rp. {{number_format($row->harga,0,',','.')}}
                      </td>
                      <td>
                        <div style="width:1rem; height:1rem; border-width:0.2em;" class="spinner-border text-success" role="status"></div>  
                        <span>
                          {{-- <button onclick="this.parentNode.querySelector('#qty').stepDown()" class="min-btn" style="width: 20px">-</button> --}}
                          <input class="qty" id="qty" style="width: 50px; text-align:center" type="number" 
                          name="qty" value="{{$row->qty}}" max="{{$row->stok}}">
                          {{-- <button onclick="this.parentNode.querySelector('#qty').stepUp()" class="plus-btn" style="width: 20px">+</button> --}}
                        </span>
                        <br><br>Stok : {{$row->stok}}
                      </td>
                      <td>{{$row->berat}} gram</td>
                      <td class="sub-col">Rp. {{number_format($sub_total,0,',','.')}}</td>
                    </tr>
                  </tbody>
              </table>
            </div>
          @endforeach
      </div>
  </div>
</div><br>

<div class="text-center align-items-center" style="display: flex; justify-content: center; align-items: center;">
  <form action="/checkout" method="GET">
    <button id="btn-checkout" style="display: flex; flex-direction: column; justify-content: center; align-items:center; width: 200px; height: 50px; font-size: 17px;" type="submit" class="btn btn-success">
    Checkout<br>
    <b class="total-bayar">Rp. {{number_format($grand_total,0,',','.')}}</b> 
    </button>
  </form>
</div>  
          @endif

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $('.qty').attr('min',1);
    $('.spinner-border').hide();

      $('.qty').on('change', function() {
        var index = $(".qty").index($(this));
        var harga = $(".harga").eq(index).val();
        var nama_produk = $(".nama_produk").eq(index).val();
        var qty = $(".qty").eq(index).val();
        var maxValue = parseInt($('.qty').eq(index).attr('max'));

        if (qty < 1)
        {
          alert('MINIMAL 1');
          $(".qty").eq(index).val('1')
          qty = 1;
        } else if (qty > maxValue)
        {
          alert('MAKSIMAL ' + maxValue);
          $(".qty").eq(index).val(maxValue);
          qty = maxValue;
        }

        var subtotalColumn = $(".sub-col").eq(index);
        var newsubVal = qty * harga;
        var formattednewsubVal = parseFloat(newsubVal).toLocaleString('id-ID', {
                                      minimumFractionDigits: 0,
                                      maximumFractionDigits: 0,
                                      useGrouping: true
                                  });

        $('.spinner-border').eq(index).show();



        subtotalColumn.html('');
        subtotalColumn.append(
        `
          Rp. ${formattednewsubVal} 
        `  
        );

        var all = $(".sub-col").map(function() {
          return $(this).text();
        }).get();

        var convert = all.map(price => parseInt(price.replace(/\D/g, ''), 10));

        var sum = 0;
        for (let i = 0; i < convert.length; i++) {
          sum += convert[i];
        }

        var formattedSum = parseFloat(sum).toLocaleString('id-ID', {
                                      minimumFractionDigits: 0,
                                      maximumFractionDigits: 0,
                                      useGrouping: true
                           });
                        
        $('.total-bayar').html('');
        $('.total-bayar').append(
        `
          Rp. ${formattedSum}
        `  
        );

        setTimeout(function() {
          $('.spinner-border').eq(index).hide();
                }, 200);
      });
      
      $('.btn-hapus').on('click', function() {
        var index = $(".btn-hapus").index($(this));
        var nama_produk = $(".nama_produk").eq(index).val();
        var table = $(".table").eq(index);

        $.ajax({
                  url: "{{ route('delete.keranjang') }}",
                  type: 'DELETE',
                  dataType: 'text',
                  data: 
                  {
                      _token: "{{ csrf_token() }}",
                      nama_produk: nama_produk
                  },
                  success: function(){
                      table.html('');
                      $('#sukses').slideDown(150);
                      if($('.thead-dark').length === 0) 
                      {
                        location.reload();
                      }


                  },
                  error: function (xhr, status, error) {
                      console.error(xhr.responseText);
                      // Handle error response
                  },
                  complete: function() {
                    var all = $(".sub-col").map(function() {
                                return $(this).text();
                              }).get();

                    var convert = all.map(price => parseInt(price.replace(/\D/g, ''), 10));

                    var sum = 0;
                    for (let i = 0; i < convert.length; i++) {
                      sum += convert[i];
                    }

                    var formattedSum = parseFloat(sum).toLocaleString('id-ID', {
                                                  minimumFractionDigits: 0,
                                                  maximumFractionDigits: 0,
                                                  useGrouping: true
                                      });
                                    
                    $('.total-bayar').html('');
                    $('.total-bayar').append(
                    `
                      Rp. ${formattedSum}
                    `  
                    );
                  }
        });
                  setTimeout(function() {
                      $('#sukses').slideUp(900);
                  }, 1000);
      });

      $('#btn-checkout').on('click', function(e) {
        e.preventDefault();
        $(".nama_produk").each(function(index) {
            var namaProduk = $(".nama_produk").eq(index).val();
            var qty = $(".qty").eq(index).val(); 
            
            $.ajax({
                    url: "{{ route('qty.keranjang') }}",
                    type: 'PUT',
                    dataType: 'text',
                    data: 
                    {
                        _token: "{{ csrf_token() }}",
                        nama_produk: namaProduk,
                        qty: qty
                    },
                    success: function(){
                      window.location.href = '/checkout';
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
            });
        });
      });
  });
</script>
</body>
</html>