@extends('partials.linkrel')

<form method="post">
        @csrf
            <div class="bg">
                <div class="container d-flex justify-content-center flex-column">
                    <div id="sukses" class="fixed-top mt-5 alert alert-success text-center" role="alert">
                        Berhasil terdaftar ! Silahkan <a href="/login">Login</a>
                    </div>
                    @if(session('alert'))
                        <div class="fixed-top mt-4 alert alert-danger text-center" role="alert">
                            {{ session('alert.message') }}
                        </div>
                    @endif                    
                <div class="mt-100 input-group mb-3">
                    <input @if(session('alert')) id="email-google" style="font-weight: bold;" readonly value="{{ session('email') }}" @endif id="email" name="email" type="email" class="form-control form-control-lg fs-6" placeholder="Email">
                </div>
                    <div style="padding:5px; padding-bottom:5px;" id="error-email" class="alert alert-danger text-center"></div>
                <div class="input-group mb-3">
                    <input @if(session('alert')) id="nama-lengkap-google" style="font-weight: bold;" readonly value="{{ session('nama_lengkap') }}" @endif id="nama_lengkap" name="nama_lengkap" type="text" class="form-control form-control-lg fs-6" placeholder="Nama Lengkap">
                </div>
                    <div style="padding:5px; padding-bottom:5px;" id="error-nama-lengkap" class="alert alert-danger text-center"></div>
                <div class="input-group mb-3">
                    <input id="username" name="username" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Username">
                </div>
                    <div style="padding:5px; padding-bottom:5px;" id="error-username" class="alert alert-danger text-center"></div>
                <div class="input-group mb-3">
                    <input id="no_hp" name="no_hp" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="No.HP">
                </div>
                    <div style="padding:5px; padding-bottom:5px;" id="error-no-hp" class="alert alert-danger text-center"></div>
                <div class="input-group mb-3">
                    <input id="password" name="password" type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
                </div>
                    <div style="padding:5px; padding-bottom:5px;" id="error-password" class="alert alert-danger text-center"></div>
                <div class="input-group mb-3 mt-3">
                    <button id="submit-btn" type="submit" class="btn btn-lg btn-primary w-100">DAFTAR</button>
                </div>
                <div @if(session('alert')) hidden @endif class="text-center mb-3">
                    <b>ATAU</b>
                </div>
                <div @if(session('alert')) hidden @endif class="row">
                    <div class="col-md-12 mb-3">
                    <a href="/auth/google/redirect" id="google-btn" style="display: flex; align-items: center;" class="btn btn-lg btn-light btn-block text-uppercase btn-outline justify-content-center">
                        <img style="width: 20px; height: 20px;" src="https://img.icons8.com/color/16/000000/google-logo.png">&nbsp;Daftar dengan Google
                    </a>
                    </div>
                </div>
            <a style="color: wheat" href="https://www.freepik.com/free-vector/gradient-monochromatic-abstract-background_19114077.htm#query=green%20abstract%20background&position=0&from_view=keyword&track=ais&uuid=d880b064-822b-455e-9799-2be4e7ba9d88">Image by pikisuperstar</a> on Freepik
            </div>
            
        </div>
</form>
        
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('#error-email').hide();
    $('#error-username').hide();
    $('#error-nama-lengkap').hide();
    $('#error-no-hp').hide();
    $('#error-password').hide();

    if(localStorage.getItem("submit-btnClicked"))
        {      
            localStorage.removeItem("submit-btnClicked");     
            $('#sukses').show();
            setTimeout(function() {
                $('#sukses').slideUp(900);
                }, 6000);
        }
    
    $('#submit-btn').on('click', function(e) {
        e.preventDefault();
        $('#error-email').html('');
        $('#error-email').hide();
        $('#error-username').html('');
        $('#error-username').hide();
        $('#error-nama-lengkap').html('');
        $('#error-nama-lengkap').hide();
        $('#error-no-hp').html('');
        $('#error-no-hp').hide();
        $('#error-password').html('');
        $('#error-password').hide();

        let email = $('#email').val();
        let username = $('#username').val();
        let nama_lengkap = $('#nama_lengkap').val();
        let no_hp = $('#no_hp').val();
        let password = $('#password').val();

                $.ajax({
                  url: "{{ route('daftar') }}",
                  type: 'POST',
                  dataType: 'text',
                  data: 
                  {
                      _token: "{{ csrf_token() }}",
                      email: email,
                      username: username,
                      nama_lengkap: nama_lengkap,
                      no_hp: no_hp,
                      password: password
                  },
                  success: function(){
                    location.reload();
                    localStorage.setItem("submit-btnClicked", true);
                  },
                  error: function (xhr) {
                    var errorMsg = JSON.parse(xhr.responseText);
                    console.error(errorMsg);
                    $.each(errorMsg, function(index, error) {
                        $.each(error, function(index, val) {  
                            if (val.indexOf('email') !== -1) 
                            {
                                $('#error-email').show();
                                $('#error-email').append(`${val}`);
                            }
                            if (val.indexOf('username') !== -1) 
                            {
                                $('#error-username').show();
                                $('#error-username').append(`${val}`);
                            }
                            if (val.indexOf('nama lengkap') !== -1) 
                            {
                                $('#error-nama-lengkap').show();
                                $('#error-nama-lengkap').append(`${val}`);
                            }
                            if (val.indexOf('no hp') !== -1) 
                            {
                                $('#error-no-hp').show();
                                $('#error-no-hp').append(`${val}`);
                            }
                            if (val.indexOf('password') !== -1) 
                            {
                                $('#error-password').show();
                                $('#error-password').append(`${val}`);
                            }      
                        });
                        
                    });
                  }
                });
    });
});
</script>
</body>
</html>
