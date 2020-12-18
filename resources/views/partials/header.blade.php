<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="{{ url('')}}">Shop v8</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('category')}}">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('products')}}">Products</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('basket')}}">My Basket</a>
                    </li>
                @endauth
            </ul>
            <ul class="navbar-nav mr-sm-4">
                @guest
                    <li class="nav-item ml-auto">
                        <a class="nav-link" href="{{url('auth/login')}} ">Log In</a>
                    </li>
                    <li class="nav-item ml-auto">
                        <a class="nav-link" href=" {{url('users/create')}}">Register</a>
                    </li>
                @endguest
            </ul>
            @auth
                <ul class="navbar-nav mr-sm-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hello {{Auth::user()->name}}!</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ url('auth/logout')}}">Logout</a>
                            <a class="dropdown-item" href="{{ url('users/'. Auth::id())}}">My profile</a>
                            @if (Auth::user()->admin)
                                <a class="dropdown-item" href="{{ url('users/'. Auth::id(). '/categories') }}">Categories panel</a>
                                <a class="dropdown-item" href="{{ url('users/'. Auth::id()). '/products' }}">Products panel</a>
                            @endif
                        </div>
                    </li>
                </ul>
            @endauth
        </div>
    </nav>
</header>
