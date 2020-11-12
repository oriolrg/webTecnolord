                                @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">@lang('headernavbar.Area Client')</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                @lang('headernavbar.Logout')
                                            </a>
                                            <a class="dropdown-item" href="{{url('/clients')}}">
                                                @lang('headernavbar.Area Client')
                                            </a>
                                            @if( Auth::user()->admin == 1)
                                                <a class="dropdown-item" href="{{url('/administra')}}">
                                                    @lang('headernavbar.Area Administrador')
                                                </a>
                                            @endif
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest