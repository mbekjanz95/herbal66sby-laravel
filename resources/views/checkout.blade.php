<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>CHECKOUT</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;900&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="style2.css">
        <script src="https://kit.fontawesome.com/a59b9b09ab.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="responsive.js"></script>
    </head>
<body>
@include('partials.navbar')

<div class="container mt-4">
    <div class = "card bg-success">
        <div class = "card-header">
            <h3 class = "text-white card-title">Data Pembeli</h3>
        </div>
        <div class = "bg-light card-body">
            <ul style="list-style: none;">
                <li>Nama Pembeli : <b>{{$customer->nama_lengkap}}</b></li>
                <li>No. HP : <b>{{$customer->no_hp}}</b></li>
                <li>Email : <b>{{$customer->email}}</b></li>
            </ul>
        </div>
    </div>
    <div class = "mt-4 card bg-success">
        <div class = "card-header">
            <h3 class = "text-white card-title">Daftar Belanja</h3>
        </div>
        <div class = "bg-light card-body">
            <div style="color: red;" class="keterangan">Geser tabel ke kanan (->) untuk informasi lebih lengkap</div> 
            @php
                $total_belanja = 0;
                $total_berat = 0;
            @endphp

            @foreach ($keranjang as $row)
            @php
                $sub_total= $row->harga * $row->qty;
                $sub_berat= $row->berat * $row->qty;
                $total_belanja += $sub_total;
                $total_berat += $sub_berat;
            @endphp
            <div class="mt-4 table-responsive">
                <table class="table table-bordered" style="border-width:8px;">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col"></th>  
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga @</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Berat @</th>
                        <th scope="col">Sub Total</th>
                        <th scope="col">Total Berat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td><img class="thumbnail" src="{{$row->url_gambar}}" style="height: 100px;width: 100px;"></td>  
                        <td>{{$row->nama_produk}}</td>
                        <td>Rp. {{number_format($row->harga,0,',','.')}}</td>
                        <td>{{$row->qty}}</td>
                        <td>{{$row->berat}} gram</td>
                        <td>Rp. {{number_format($sub_total,0,',','.')}}</td>
                        <td>{{$sub_berat}} gram</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    </div>
    <div class = "mt-4 card bg-success">
        <div class = "card-header">
            <h3 class = "text-white card-title">Pilih Kurir</h3>
        </div>
        <div class = "bg-light card-body">
            <ul style="list-style: none;">
                <li id="berat" value="{{$total_berat}}">Berat Total : <b>{{$total_berat}} gram</b></li>
                <li class="col-md-6" ><span id="label-alamat">Alamat :</span> 
                <div><input class="form-select" id="alamat" type="text"></div>
                <div style="color: red;" class="alert-alamat">Silahkan masukkan alamat dengan benar !</div> 
                </li><br>
                <li class="col-md-6"> Kota/Kab. :
                    <select name="kota" id="kota" class="form-select">
                        <option id="selected-kota" value="" disabled selected>-- PILIH KOTA --</option>
                        @foreach ( $kota as $row )
                            <option value="{{$row->city_id}}">{{$row->city_name}}
                            ({{$row->type}}), {{$row->province}}</option>
                        @endforeach
                    </select>  
                </li><br>
                <li class="col-md-6"> Kurir :
                    <select name="kurir" id="kurir" class="form-select">
                        <option value="" disabled selected>-- PILIH KURIR --</option>
                        <option value="jne">JNE</option>
                        <option value="pos">POS</option>
                        <option value="tiki">TIKI</option>
                    </select>  
                </li><br>
                <li class="col-md-6">
                    <label id="label-layanan" for="layanan">Layanan :</label> 
                    <div style="display: flex; align-items: center;">
                    <select name="layanan" id="layanan" class="form-select">
                        <option value="" disabled selected>-- PILIH LAYANAN --</option>
                    </select>  
                        <span id="load-layanan" style="width:1rem; height:1rem; border-width:0.2em; margin-left:10px;" class="spinner-border text-success" role="status"></span>  
                    </div>
                </li><br>
                <li>
                    <button id="reset" style="width: 180px">PILIH ULANG KOTA DAN/ATAU KURIR</button>
                </li>
            </ul>    
        </div>
    </div>
    <div id="detail-bayar" class = "mt-4 card bg-success">
        <div class = "card-header">
            <h3 class = "text-white card-title">Rincian Pembayaran</h3>
        </div>
        <div class = "bg-light card-body co">
            <ul style="list-style: none;">
                <li id="total-belanja" value="{{$total_belanja}}">Total Belanja : <b> Rp. {{number_format($total_belanja,0,',','.')}}</b> </li>
                <li>
                    Biaya Kirim : <b id="biaya-kirim"></b> 
                    <span id="load-kirim" style="width:1rem; height:1rem; border-width:0.2em;" class="spinner-border text-success" role="status"></span>
                </li><br>
                <li>
                    <b>Grand Total :</b><b id="grand-total"></b>
                    <span id="load-gtotal" style="width:1rem; height:1rem; border-width:0.2em;" class="spinner-border text-success" role="status"></span> 
                </li>
            </ul>
        </div>
    </div>

    <a href="/payment">
        <div style="cursor: default;" class="text-center">
        <button id="btn-payment" class="mt-4" style="cursor:pointer; width: 180px; 
        height: 60px; font-size: 15px;">
        PILIH METODE PEMBAYARAN 
        </button>
        </div>
    </a>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('#kurir').attr("disabled", true); 
        $('#layanan').attr("disabled", true); 
        $('#btn-payment').attr("disabled", true);
        $('#load-layanan').hide();
        $('#load-kirim').hide();
        $('#load-gtotal').hide();

        if ($('#berat').val() == 0)
        {
            $('#kota').attr('disabled', true);
            $('#reset').attr('disabled', true);
        }

        $('.text-center').on('click', function(e) {
            e.preventDefault();
        });

        $('#btn-payment').on('click', function() {
            var alamatLength = $('#alamat').val().length;
            if (alamatLength < 10) {
                document.getElementById("label-alamat").scrollIntoView();
                $('.alert-alamat').show();
            } 
        });
        
        $('#kota').select2({
            placeholder: "--PILIH KOTA--",
        }); 

            $('#kota').on('change', function() {
                $('#kurir').attr("disabled", false);
                $('#kota').select2("enable", false); 
            });

                    $('#kurir').on('change', function(e){
                        e.preventDefault();
                        $('#load-layanan').show();
                        $('#reset').attr('disabled', true);
                        $(this).attr("disabled", true);

                            let destination = $('#kota').val();
                            let courier = $('#kurir').val();
                            let weight = $('#berat').val();
                        $.ajax({
                            url: "{{ route('check-ongkir') }}",
                            type: 'POST',
                            dataType: 'json',
                            data: 
                            {
                                _token: "{{ csrf_token() }}",
                                destination: destination,
                                courier: courier,
                                weight: weight
                            },
                            success: function(response){
                                $('#load-layanan').hide();
                                $('#reset').attr('disabled', false);
                                $('#kurir').attr("disabled", true);
                                $('#layanan').attr("disabled", false); 
                                $.each(response, function(i, val){
                                    if ($('#layanan').is(':empty')) 
                                    {
                                        $('#layanan').append(
                                        `
                                        <option value="" disabled selected>-- PILIH LAYANAN --</option>
                                        <option value="${val.service}">${val.service}, ${val.description}, ${val.cost[0].etd.replace(/ Hari/i, '')} Hari</option>
                                        `);
                                    } else 
                                    {
                                        $('#layanan').append(
                                        `
                                        <option value="${val.service}">${val.service}, ${val.description}, ${val.cost[0].etd.replace(/ Hari/i, '')} Hari</option>
                                        `);
                                    }
                                
                                });
                            }
                        });
                    });

                    $('#layanan').on('change', function(e){
                        e.preventDefault();
                        document.getElementById("detail-bayar").scrollIntoView();
                        $('#load-kirim').show();
                        $('#load-gtotal').show();
                        $('#biaya-kirim').html('');
                        $('#grand-total').html('');

                            let destination = $('#kota').val();
                            let courier = $('#kurir').val();
                            let weight = $('#berat').val();
                            let layanan = $('#layanan').val();
                        $.ajax({
                            url: "{{ route('check-harga') }}",
                            type: 'POST',
                            dataType: 'json',
                            data: 
                            {
                                _token: "{{ csrf_token() }}",
                                destination: destination,
                                courier: courier,
                                weight: weight,
                                layanan: layanan
                            },
                            success: function(response){
                                let totalbelanja=$('#total-belanja').val();
                                let totalkirim=parseInt(response);
                                let sum=totalbelanja+totalkirim;
                                let formattedResp = parseFloat(response).toLocaleString('id-ID', {
                                                        minimumFractionDigits: 0,
                                                        maximumFractionDigits: 0,
                                                        useGrouping: true
                                                    });
                                let formattedSum = parseFloat(sum).toLocaleString('id-ID', {
                                                        minimumFractionDigits: 0,
                                                        maximumFractionDigits: 0,
                                                        useGrouping: true
                                                    });

                                $('#load-kirim').hide();
                                $('#load-gtotal').hide();
                                $('#biaya-kirim').html('Rp ' + formattedResp);
                                $('#grand-total').html('Rp ' + formattedSum);
                                $('#btn-payment').attr("disabled", false); 
                            }
                        });
                    });
        
            $('#reset').on('click', function() {
                $('#btn-payment').attr("disabled", true);
                $('#kurir').attr("disabled", true);
                $('#kota').select2("enable");
                $('#kota').html('');
                $('#kota').append(
                `
                <option id="selected-kota" value="" disabled selected>-- PILIH KOTA --</option>
                    @foreach ( $kota as $row )
                        <option value="{{$row->city_id}}">{{$row->city_name}}
                        ({{$row->type}}), {{$row->province}}</option>
                    @endforeach
                `);
                $('#layanan').attr("disabled", true);  
                $('#biaya-kirim').html('');
                $('#grand-total').html('');
                $('#kurir').prop('selectedIndex',0);
                $('#layanan').html('');
                $('#layanan').append(
                `
                <option value="" disabled selected>-- PILIH LAYANAN --</option>
                `);
            });
    });
    
</script>
</body>
</html> 