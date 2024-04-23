@extends('partials.linkrel')

<form action="/login" method="post">
        @csrf
    <div class="bg">
        <div class="container d-flex justify-content-center flex-column">
                <div id="alert-login" class="fixed-top mt-5 alert alert-danger text-center" role="alert">
                    Silahkan login terlebih dahulu !
                </div>
            <div class="mt-100 input-group mb-3">
                <input id="email" name="email" type="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email">
            </div>
            <div class="input-group mb-3">
                <input id="password" name="password" type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
            </div>
            @if ($errors->any())
                <div style="height: 50px; font-size:15px; display: flex; align-items: center; 
                background-color: rgb(214, 52, 52); border:none; color:white;" class="alert alert-danger">  
                    @foreach ($errors->all() as $message) 
                        - {{ $message }}<br>
                    @endforeach
                </div>
            @endif
            <div class="input-group mb-3 d-flex">
                <div class="form-check">
                    <input type="checkbox" class="form-check-in" id="formCheck">
                    <label for="formCheck" style="color: white">Ingat Saya</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <button type="submit" class="btn btn-lg btn-primary w-100">LOGIN</button>
            </div>
            <div class="text-center mb-3">
                <b>ATAU</b>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                <a href="/auth/google/redirect" id="google-btn" style="display: flex; align-items: center;" class="btn btn-lg btn-light btn-block text-uppercase btn-outline justify-content-center">
                    <img style="width: 20px; height: 20px;" src="https://img.icons8.com/color/16/000000/google-logo.png">&nbsp;Login dengan Google
                </a>
                </div>
            </div>
            <div class="text-center mb-3">
                <b>Belum punya akun ?<a style="color: wheat" class="ml-2" href="/registration">DAFTAR</a></b>
            </div>
            <div class="text-center">
                <a style="color: wheat" href="https://www.freepik.com/free-vector/gradient-monochromatic-abstract-background_19114077.htm#query=green%20abstract%20background&position=0&from_view=keyword&track=ais&uuid=d880b064-822b-455e-9799-2be4e7ba9d88">Image by pikisuperstar</a><br>on Freepik
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function(){
    $('#alert-login').hide();
    if(localStorage.getItem("navbar-btnClicked") || localStorage.getItem("home-btnClicked"))
        {      
            localStorage.removeItem("navbar-btnClicked");     
            localStorage.removeItem("home-btnClicked");
            $('#alert-login').show();
            $('#email').addClass('mt-5');
        }
  });
</script>
</body>
</html>
