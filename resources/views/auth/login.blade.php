
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Login</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" >


    <!-- Custom styles for this template -->
    <link href="{{ asset('css/floating-labels.css') }}" rel="stylesheet">
  </head>
  <body>
      <form class="form-signin" method="POST" action="{{ route('auth.login') }}">@csrf
    <div class="card">
        <div class="card-body">
                @if (session()->has('msg'))
                <div class="alert alert-warning" role="alert">
                 {{ session()->get('msg') }}
                  </div>
                @endif
                <div class="text-center mb-4">
                    <img class="mb-4" src="{{ asset('img/download.png') }}" alt="" width="72" height="72">
                  <h1 class="h3 mb-3 font-weight-normal">Casureco III</h1>
                  <p>Employee Medical Record</p>
                </div>
          
                <div class="form-label-group">
                  <input type="text" id="inputUsername" class="form-control" name="username" placeholder="Username" required autofocus>
                  <label for="inputUsername">Username</label>
                </div>
          
                <div class="form-label-group">
                  <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
                  <label for="inputPassword">Password</label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            </div>
        </div>
    </form>
</body>
</html>
