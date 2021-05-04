@component('mail::message')

    <div>
        <h3>Hi, {{ $name }}</h3>
        <p>Thank you for register to our company <p>
        <p>Please click on the below link to verify your email account</p>
        <br/>
        <a href="{{url('/api/user/verify', $token)}}">Verify Email</a>
    </div>
