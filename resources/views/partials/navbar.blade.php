<nav class="top-header flex">
    <div class="left ">
       <a target="_blank" href="https://cekresi.com/" class="top-menu-left"> 
        <i class="fa fa-location-arrow" aria-hidden="true">&nbsp;</i> Lacak Pengiriman 
       </a>
    </div>
      @auth
        <input type="checkbox" id="check">
        <label for="check" class="burger-btn"> 
          <i class="fas fa-bars"></i>
        </label>
    
        <ul class="burger">
          <li><a href="#">Halo, {{ auth()->user()->username }}</a></li>
          <li><a href="/wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i> Wishlist</a> </li>
          <li><a href="/keranjang"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Keranjang</a></li>
          <li>
            <form action="/logout" method="post">
               @csrf
               <button style="background: none; border:none; color: #0da000; font-size: 17px; padding: 7px 13px; font-weight: 600;" type="submit">LOG OUT</button>
             </form>
           </li>
        </ul>
      @else
        <input type="checkbox" id="check">
        <label for="check" class="burger-btn"> 
          <i class="fas fa-bars"></i>
        </label>
    
        <ul class="burger">
          <li><a href="/login">Masuk</a></li>
          <li><a href="/registration">Daftar</a></li>
        </ul>
      @endauth
     
    <div class="right ">
      <a class="top-menu-right" style="cursor: pointer;"> 
        <i class="fas fa-map-marker-alt"></i> Simorejo Timur I/66 Surabaya
      </a>
      <a target="_blank" href="https://www.instagram.com/herbal66sby/" class="top-menu-right"> 
        <i class="fa-brands fa-instagram"></i> herbal66sby
      </a>
    </div>
</nav>

<nav class="navbar sticky flex navbar-shadow">
      <a href="/home"><img class="logo" src="herbal.png"></a>

      <form class="src-produk" action="/cari" method="get">
        <input class="inp-produk" type="text" placeholder="Cari produk/jenis keluhan" name="cari">
        <button type="submit" class="btn-src-produk">CARI</button>
      </form>

    <ul class="flex-icon">
        @auth
          <li>
            <a href="/wishlist" class="navbar-icon">
              <i class="fa fa-heart-o" aria-hidden="true"></i>
            </a>
          </li>
          <li class="icon-menu-space">
            <a href="/keranjang" class="navbar-icon">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </a>
          </li>
          <li id="username" name="username">
            <a href="#" class="navbar-menu">
              Halo, {{ auth()->user()->username }}
            </a>
          </li>
          <li>
            <form action="/logout" method="post">
              @csrf
              <button style="background: none; border:none;" class="navbar-menu" type="submit">LOGOUT</button>
            </form>
          </li>
        @else
           <li>
              <i style="cursor: pointer" id="wish-btn" class="navbar-icon fa fa-heart-o" aria-hidden="true"></i>
           </li>
           <li class="icon-menu-space">
              <i style="cursor: pointer" id="cart-btn" class="navbar-icon fa fa-shopping-cart" aria-hidden="true"></i>
           </li>
           <li>
            <a href="/login" class="navbar-menu">
              Masuk
            </a>
           </li>
           <li>
            <a href="/registration" class="navbar-menu">
              Daftar
            </a>
           </li>
        @endauth
    </ul>
  </nav>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
      $('#wish-btn, #cart-btn').on('click', function() {
         localStorage.setItem("navbar-btnClicked", true);
         window.location.href = '/login';
      });

      $('.inp-produk').val('');
  
      $('.inp-produk').on('keyup', function() {
        $('.inp-produk').removeAttr('placeholder');
      });
      
      $('.inp-produk').on('blur', function() {
        $('.inp-produk').attr('placeholder','Cari produk/jenis keluhan');
        $('.inp-produk').val('');
      });
  
      $('.burger-btn').on('click', function() {
        if ($('#check').is(':checked')) 
        {
          $('body').css('overflow','visible');
        } else 
        {
          $('body').css('overflow','hidden');
        }
      });
    });      
</script>
  