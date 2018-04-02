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

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <ul class="mr-auto mt-2 mt-lg-0 nav">
                    <li class="nav-item {{ active_class(if_route('topics.index')) }}"><a class="nav-link" href="{{ route('topics.index') }}">话题</a></li>
                    <li class="nav-item {{ active_class((if_route('categories.show') && if_route_param('category', 1))) }}"><a class="nav-link" href="{{ route('categories.show', 1) }}">分享</a></li>
                    <li class="nav-item {{ active_class((if_route('categories.show') && if_route_param('category', 2))) }}"><a class="nav-link" href="{{ route('categories.show', 2) }}">教程</a></li>
                    <li class="nav-item {{ active_class((if_route('categories.show') && if_route_param('category', 3))) }}"><a class="nav-link" href="{{ route('categories.show', 3) }}">问答</a></li>
                    <li class="nav-item {{ active_class((if_route('categories.show') && if_route_param('category', 4))) }}"><a class="nav-link" href="{{ route('categories.show', 4) }}">公告</a></li>

            </ul>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

                <li class="nav-item">
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </li>
                <!-- Authentication Links -->
                @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login')  }}">登录</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('topics.create') }}">
                            <i class="material-icons">add</i>
                        </a>
                    </li>
                    {{-- 消息通知标记 --}}
                    <li class="nav-item notifications-badge">
                        <a href="{{ route('notifications.index') }}">
                            <span class="badge badge-pill badge-info badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'fade' }} " title="消息提醒">
                                {{ Auth::user()->notification_count }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="user-avatar pull-left" style="margin-right:8px;">
                                <img src="{{config('app.url').Auth::user()->avatar}}" class="img-responsive rounded-circle" width="30px" height="30px">
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

</nav>