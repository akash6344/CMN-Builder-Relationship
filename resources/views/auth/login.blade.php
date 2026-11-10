<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login · CMNHousing BRM</title>
  <link rel="stylesheet" href="{{ asset('css/brm.css') }}">
</head>
<body>
  <div class="auth-wrap">
    <form class="auth-card" method="POST" action="{{ route('login.store') }}">
      @csrf
      <h1>Builder Relationship</h1>
      <p>Sign in to the CMNHousing BRM portal</p>
      @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
      @endif
      <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" id="email" type="email" name="email" value="{{ old('email', 'anita.brm@cmnhousing.test') }}" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" id="password" type="password" name="password" required>
      </div>
      <button class="btn btn-primary" type="submit" style="width:100%;">Sign in</button>
      <p class="muted">Demo: anita.brm@cmnhousing.test / password</p>
    </form>
  </div>
</body>
</html>
