<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand" href="{{ url('/') }}">
            MTBBS
        </a>
    <!-- Collapsed Hamburger -->
    <button class="navbar-toggler my-2 my-sm-0" type="button" data-toggle="collapse" data-target="#app-navbar-collapse" aria-controls="app-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

        <div class="justify-content-between">
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login')  }}">登录</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px;">
                                <img src="{{ config('app.url').Auth::user()->avatar }}" class="img-responsive rounded-circle" width="30px" height="30px">
                            </span>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="{{ route('users.show',Auth::id()) }}">
                                <i class="material-icons">perm_identity</i>个人中心
                            </a>
                             <a class="dropdown-item" href="{{ route('users.edit',Auth::id()) }}">
                                 <i class="material-icons">edit</i>编辑资料
                             </a>
                             <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                 <i class="material-icons">power_settings_new</i>退出登录
                             </a>
                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                             </form>
                        </div>
                    </li>
                @endguest

            </ul>

        </div>
        </div>
</div>
</nav>