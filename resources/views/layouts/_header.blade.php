<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="navbar-header">
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                MTBBS
            </a>
        </div>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <div class="justify-content-end">

            <!-- Collapsed Hamburger -->
            <button class="navbar-toggler my-2 my-sm-0" type="button" data-toggle="collapse" data-target="#app-navbar-collapse" aria-controls="app-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            {{--<div class="justify-content-end">--}}
            <ul class="navbar-nav ">
                <!-- Authentication Links -->
                <li class="nav-item"><a class="nav-link" href="#">登录</a></li>
                <li class="nav-item"><a class="nav-link" href="#">注册</a></li>
            </ul>

            </div>
        {{--</div>--}}
        </div>
    </div>
</nav>