@extends('partials.linkrel')
@include('partials.navbar')

<div class="container mt-4">
    <h4 class="about-title">Sekilas Tentang <span class="colored">Kami</h4>
    <p class="paragraf mt-3" style="text-align: justify;">Kami adalah toko herbal yang berdiri tahun 2020,
      seiring tren pandemi COVID 19 yang melanda secara global pada saat itu.
      Motto kami adalah memberikan sebuah alternatif dari obat-obatan kimia yang 
      tentunya memiliki sejumlah efek samping yang buruk dalam
      penggunaan jangka panjang.</p>
    <p class="paragraf" style="text-align: justify;">Merambah melalui pasar offline maupun online,
      kini kami sudah memiliki kesan baik yang dirasakan langsung oleh customer-customer kami
      yang memberikan ulasan-ulasannya di Google Maps.
      Kini kami mencoba membuat sebuah E-commerce untuk toko kami,
      yang pastinya membuat proses transaksi lebih mudah, aman dan nyaman.    
    </p>
</div>

<div class="cover">
    <button class="bt-left" onclick="leftScroll()">
      <i class="fas fa-angle-double-left"></i>
    </button>
    <div class="scroll-images">
      @auth
        @foreach ($products as $produk )
          <div class="child">
          <a href="{{$produk->nama_produk}}">  
          <img src="{{$produk->url_gambar}}">
          <h4 class="card-description">{{$produk->nama_produk}}</h4>
          <h5>Harga : Rp. {{number_format((float)$produk->harga,0,',','.')}}</h5>
          </a>
          </div>
        @endforeach
      @else
        @foreach ($products as $produk )
          <div class="child">
          <a style="cursor: pointer" id="thumb-produk">
          <img src="{{$produk->url_gambar}}">
          <h4 class="card-description">{{$produk->nama_produk}}</h4>
          <h5>Harga : Rp. {{number_format((float)$produk->harga,0,',','.')}}</h5>
          </a>
          </div>
        @endforeach
      @endauth
    </div>
      <button class="bt-right" onclick="rightScroll()">
        <i class="fas fa-angle-double-right"></i>
      </button>
</div>

    @auth
      <a href="/daftar-produk">  
        <button type="button" class="btn btn-success mb-5 ml-3">
          LIHAT PRODUK SELENGKAPNYA >>
        </button>
      </a>
    @else
      <button id="btn-list-product" type="button" class="btn btn-success mb-5 ml-3">
        LIHAT PRODUK SELENGKAPNYA >>
      </button>
    @endauth

    <section id="maps" class="mt-3">
      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15831.383383059389!2d112.7125775!3d-7.258379!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7ffdcff2df995%3A0xd63c07f7ebda485d!2sHERBAL%2066%20SURABAYA%20(Habbatussauda%2Fjinten%2C%20Minyak%20Zaitun%2C%20Madu%2C%20dll)!5e0!3m2!1sid!2sid!4v1709784014881!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>


<footer class="mt-4">
<h1>Hubungi kami</h1>
<h4>Jika berminat silahkan langsung datang ke toko offline kami
  atau hubungi kami via Whatsapp untuk Chat</h4>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function(){
    $('.about-title').fadeIn(1000).promise().done(function() {
      $('.colored').fadeIn(1000).promise().done(function() {
        $('.paragraf').fadeIn(1500);
      });
    });
    $('#btn-list-product, #thumb-produk').on('click', function() {
       localStorage.setItem("home-btnClicked", true);
       window.location.href = '/login';
    });
  });
</script>
  </body>
</html>
