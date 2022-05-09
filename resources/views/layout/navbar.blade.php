<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
  <div class="container">
      <a class="navbar-brand" href="#">Medical<span style="color: #FEAF2F;">Diagnosis</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto  me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link active" aria-current="page" style="display: none" href="#">Home</a>
              </li>

          </ul>
          <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link "  href="{{ route('auth.logout') }}"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout <i class="text-danger fas fa-sign-out-alt"></i></a>
              </li>
              <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </ul>
      </div>
  </div>
</nav>