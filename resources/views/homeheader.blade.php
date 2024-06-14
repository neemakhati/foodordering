<header class="header-area header-sticky">
    <div>


        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <ul class="nav">
                        <li style="padding:10px; margin:0px;">
                            @yield('search')
                        </li>
                        <li style="padding:10px;margin-left: 300px;" class="scroll-to-section" >
                            <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">Home</a>
                        </li>
                        <li style="padding:10px;" class="scroll-to-section">
                            <a href="/about" class="{{ Request::is('about') ? 'active' : '' }}">About</a>
                        </li>
                        @foreach ($categories as $category)
                        <li style="padding:10px;" class="scroll-to-section">
                            <a href="{{ route('category.view', ['slug' => $category->slug]) }}" class="{{ Request::is('category/' . $category->slug) ? 'active' : '' }}">{{ $category->name }}</a>
                        </li>
                        @endforeach
                        <li style="padding:10px;" class="scroll-to-section">
                            @auth
                            <a href="{{ url('/showcart', Auth::user()->id) }}" class="{{ Request::is('showcart/*') ? 'active' : '' }}">
                                Cart
                            </a>
                            @endauth
                            @guest
                            <a href="/signin" class="{{ Request::is('login') ? 'active' : '' }}">Cart</a>
                            @endguest
                        </li>
                        <li style="padding:10px;" class="scroll-to-section">
                            <a href="/reservation" class="{{ Request::is('reservation') ? 'active' : '' }}">Contact Us</a>
                        </li>
                        <li style="padding:10px;">
                            @if (Route::has('signin.form'))
                                <nav>
                                    @auth
                                        <a href="/logout" class="{{ Request::is('logout') ? 'active' : '' }}"> Logout</a>
                                    @else
                                        <a href="{{ route('signin.form') }}" class="{{ Request::is('signin') ? 'active' : '' }}">Log in</a>
                                    @endif
                                </nav>
                            @endif
                        </li>
                        <li style="padding:10px;">
                            @if (Route::has('signup.form'))
                                <nav>
                                    @auth
                                    @else
                                        <a href="{{ route('signup.form') }}" class="{{ Request::is('signup') ? 'active' : '' }}">Register</a>
                                    @endauth
                                </nav>
                            @endif
                        </li>


                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
<script>
    $(document).ready(function() {
        @if(session('error'))
        alert("{{ session('error') }}");
        @elseif(session('success'))
        alert("{{ session('success') }}");
        @endif
    });
</script>
