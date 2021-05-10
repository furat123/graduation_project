{{--@component('mail::message')--}}
{{--{!! HTML::script('js/script.js') !!}--}}


    <!doctype html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="icon" href="{{ URL::asset('m.png') }}" type="image/x-icon"/>
</head>
<body>
<div>
    <h3>Hi, {{ $name }}</h3>
    <p>Please click on the below link to reset your password</p>
    <br/>
{{--    <a href="{{ url('/api/send_email_password', $token) }}"  >Reset Password</a>--}}
    <a href="{{url('/api/reset_password', $token)}}">Reset Password</a>
</div>
</body>
</html>
{{--<div--}}
{{--    id = 'mydata',--}}
{{--    data-token = "sdfgsdfg",--}}
{{--    data-new_password = "sdfgdfg">--}}
{{--</div>--}}

{{--<script>--}}
{{--    alert("sadgfdsfg");--}}
{{--    // document.getElementById("reset").onclick = async () =>--}}
{{--    // {--}}
{{--    //--}}
{{--    //     const data = {--}}
{{--    //         new_password:document.querySelector('#mydata').dataset.new_password,--}}
{{--    //--}}
{{--    //     }--}}
{{--    //     const res =  await fetch("api/reset_password" ,--}}
{{--    //         {--}}
{{--    //             method:"post",--}}
{{--    //             body: JSON.stringify(data),--}}
{{--    //             headers : {--}}
{{--    //                 Authorization: "bearer" + document.querySelector('#mydata').dataset.token--}}
{{--    //             }--}}
{{--    //         }--}}
{{--    //     )--}}
{{--    //     const result = await res.json()--}}
{{--    //--}}
{{--    //     console.log(result)--}}
{{--    // }--}}
{{--</script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('js/agax.js') }}"></script>--}}






{{--<article--}}
{{--    id="mydata"--}}
{{--    data-token={{$data}}--}}
{{--    data-index-number="12314"--}}
{{--    data-parent="cars">--}}
{{--    ...--}}
{{--</article>--}}

{{--<article--}}
{{--    id="electric-cars"--}}
{{--    data-columns="3"--}}
{{--    data-index-number="12314"--}}
{{--    data-parent="cars">--}}
{{--    ...--}}
{{--</article>--}}


{{--@component('mail::message')--}}

{{--    <div>--}}
{{--        <h3>Hi, {{ $name }}</h3>--}}

{{--        <p>Please click on the below button to reset password</p>--}}
{{--        <br/>--}}

{{--    </div>--}}

{{--    <form action="http://127.0.0.1:8000/api/reset_password" method="POST">--}}
{{--        <div>--}}

{{--            <input name="new_password"  value={{ ( $new_password )}}>--}}
{{--        </div>--}}
{{--        <div>--}}

{{--            <input name="token"  value={{ ( $token )}}>--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <button>reset password</button>--}}
{{--        </div>--}}
{{--    </form>--}}





{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">Verify Your Email Address</div>--}}
{{--                <div class="card-body">--}}

{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ __('A fresh verification link has been sent to your email address.') }}--}}
{{--                        </div>--}}

{{--                    <a href="/api/reset_password/{{$token}}">Click Here</a>.--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}



