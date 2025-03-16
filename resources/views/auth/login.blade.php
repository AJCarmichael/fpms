@extends('layouts.app')

@section('content')
<div class="card login-card">
    <div class="institute-info">
        <h2>AGNEL CHARITIES</h2>
        <p class="address">
            FR. C. RODRIGUES INSTITUTE OF TECHNOLOGY<br>
            Agnel Technical Education Complex Sector 9-A, Vashi, Navi Mumbai, Maharashtra, India<br>
            PIN - 400703
        </p>
        <img src="{{ asset('images/BUILDING-FR.jpg') }}" class="building" alt="Building Image">
        <p class="description">
            Fr. CRIT. has, within a short span of time, established itself as a leading engineering college in Mumbai University. 
            Though its reputation rests mainly on the high quality, value-based technical education that it imparts, 
            it has to its credit a verdant, well-maintained Campus and extensive facilities.
        </p>
    </div>

    <div class="login-form">
        <h2>Admin Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</div>
@endsection 