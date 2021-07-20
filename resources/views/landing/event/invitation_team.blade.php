<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Undangan Tim</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            text-decoration: none;
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background: #f6f6f6;
            font-family: 'Poppins', sans-serif;
        }

        .card{
            background-color: #fff;
            border: none !important;
            margin: 2em auto;
            border-radius: 5px;
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            box-shadow: 0 6px 31px -2px rgba(0, 0, 0, .3);
        }

        p.text-invite {
            font-size: 16px;
            color: #333;
            line-height: 2;
            font-weight: bolder;
        }

        .btn-accept{
            padding: 10px 20px;
            border-radius: 100px;
            border: none;
            font-size: 13px;
            font-weight: bold;
            background: #257aa6;
            font-family: 'Poppins', sans-serif;
            outline: none;
            color: #fff;
            text-decoration: none !important;
        }

        .btn-accept:hover{
            color: #fff;
        }

        .btn-declined{
            padding: 10px 20px;
            border-radius: 100px;
            border: none;
            font-size: 13px;
            font-weight: bold;
            background: orange;
            font-family: 'Poppins', sans-serif;
            outline: none;
            color: #fff;
            text-decoration: none !important;
        }

        .btn-declined:hover{
            color: #fff;
        }

        .card-footer{
            padding: 0 !important;
            background-color: #257aa6 !important;
            color: #fff !important;
            border: none !important;
        }
        
    </style>
</head>
<body>
    

    <div class="row px-5 mt-5">
        <div class="col-md-6 offset-md-3 white-bg pad-4 mt-4">
           <div class="card">
               <div class="card-body mb-2">
                    <div class="row">
                        <div class="col-6 text-right px-3">
                            @if ($from_invite->penggunaMhsRef)
                                @if($from_invite->penggunaMhsRef->photo)
                                    <img src="{{asset('assets/img/photo-pengguna/'.$from_invite->penggunaMhsRef->photo)}}" style="width: 50px; height:50px" alt="">
                                @else
                                    <img src="{{asset('assets/img/user.svg')}}" style="width: 50px; height:50px" alt="">
                                @endif
                            @else
                                @if($from_invite->penggunaParticipantRef->photo)
                                    <img src="{{asset('assets/img/photo-pengguna/'.$from_invite->penggunaParticipantRef->photo)}}" style="width: 50px; height:50px" alt="">
                                @else
                                    <img src="{{asset('assets/img/user.svg')}}" style="width: 50px; height:50px" alt="">
                                @endif
                            @endif
                        </div>
                        <div class="col-6">
                            @if ($to_invite->penggunaMhsRef)
                                @if($to_invite->penggunaMhsRef->photo)
                                    <img src="{{asset('assets/img/photo-pengguna/'.$to_invite->penggunaMhsRef->photo)}}" style="width: 50px; height:50px" alt="">
                                @else
                                    <img src="{{asset('assets/img/user.svg')}}" style="width: 50px; height:50px" alt="">
                                @endif
                            @else
                                @if($to_invite->penggunaParticipantRef->photo)
                                    <img src="{{asset('assets/img/photo-pengguna/'.$to_invite->penggunaParticipantRef->photo)}}" style="width: 50px; height:50px" alt="">
                                @else
                                    <img src="{{asset('assets/img/user.svg')}}" style="width: 50px; height:50px" alt="">
                                @endif
                            @endif
                        </div>
                        <div class="col-12 text-center">
                            <p class="text-invite mt-2">
                                <span class="text-primary">
                                    @if ($from_invite->penggunaMhsRef)
                                        {{$from_invite->penggunaMhsRef->nama_mhs}}
                                    @else
                                        {{$from_invite->penggunaParticipantRef->nama_participant}}
                                    @endif
                                </span> mengundang kamu untuk bergabung</p>
                        </div>
                        <div class="col-12 text-center text-right ">
                            <a href="#" onclick="acceptInvitation({{$to_invite->tim_event_id}})" class="btn-accept d-inline">Terima undangan</a>
                            <a href="#" onclick="declinedInvitation({{$to_invite->tim_event_id}})" class="btn-declined d-inline">Tolak</a>
                        </div>
                    </div>
               </div>
               <div class="card-footer">
                   <div class="row">
                    <div class="col-12 text-center">
                        <small class="text-center font-weight-bold">sievent.polindra.ac.id</small>
                    </div>
                   </div>
               </div>
           </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const acceptInvitation = (id_tim) =>{
        let id_detail = "{{$id_detail}}";
        let url = "/peserta/team/users/invite/accept/"+id_tim;
        event.preventDefault();
        $.ajax(
            {
                url: url,
                type: 'patch', 
                dataType: "JSON",
                data: {
                    "id_detail": id_detail
                },
                success: function (response){
                    console.log(response.status); 
                    if(response.status == 1){
                        window.location = "/peserta/team";
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
    }

    const declinedInvitation = (id_tim) =>{
        let id_detail = "{{$id_detail}}";
        let url = "/peserta/team/users/invite/denied/"+id_tim;
        event.preventDefault();
        $.ajax(
                {
                    url: url,
                    type: 'delete', 
                    dataType: "JSON",
                    data: {
                        "id_detail": id_detail
                    },
                    success: function (response){
                        console.log(response.status); 
                        if(response.status == 1){
                            window.location = "/peserta/team";
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
            });
    }
</script>
</body>
</html>