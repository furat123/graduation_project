@component('mail::message')

    <div>
        <h3>Hi, {{ $name }}</h3>
        <p>Please click on the below link to reset your password</p>
        <br/>
        <a  href="{{url('/api/reset_password', $token)}}">Verify Email</a>
    </div>
