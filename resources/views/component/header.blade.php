<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Line Notify</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('3128326.jpg') }}" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    
     @include('component.toast')
</head>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="#!">Line Notify</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div hidden id = 'account' data={{Auth::user()->name}}></div>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() === 'publish' ? 'active' : '' }}" aria-current="page" href="{{route('publish')}}">發送通知</a></li>
                <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() === 'settings' ? 'active' : '' }}" href="{{route('settings')}}">設定</a></li>
                @if(Auth::check() && Auth::user()->name === 'admin')
                    <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() === 'users' ? 'active' : '' }}" href="{{route('users')}}">使用者管理</a></li>
                    <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() === 'history' ? 'active' : '' }}" href="{{route('history')}}">發送歷史</a></li>
                @endif
                @if(Auth::check())
                    <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() === 'editUser' ? 'active' : '' }}" href="{{route('editUser')}}">帳號管理</a></li>
                @endif
            </ul>
            <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
        </div>
    </div>
</nav>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Line Notify</h1>
            <p class="lead fw-normal text-white-50 mb-0">發送訊息至指定聊天室</p>
        </div>
    </div>
</header>