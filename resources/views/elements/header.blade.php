<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">

        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">

            {{-- <li class="nav-item dropdown dropdown-cart me-25">
                <a class="nav-link" href="#" data-bs-toggle="dropdown">
                    <button type="button" class="btn btn-outline-secondary " style="border:none !important">
                        <span>Name</span>
                        <i data-feather="aperture" class="me-25"></i>
                    </button>
                    <i class="ficon" data-feather="aperture"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end"  style="width:20rem">
                    @php
                        $projects = App\Models\Project::where('user_id',auth()->user()->id)->where(App\Library\Utilities::CompanyId())->get();

                    @endphp
                    @foreach ($projects as $p )
                        <li class="scrollable-container media-list project_name"  onclick="project_name({{ $p->id }})"
                        @if ($p->id == auth()->user()->project_id)
                            style="background-color:#D5D2FA;";
                        @endif
                        >
                            <div class="list-item align-items-center">
                                <div class="list-item-body flex-grow-1">
                                    <div class="media-heading">
                                        <h6 class="cart-item-title">
                                            <a class="text-body"  onclick="project_name({{ $p->id }})" href="#"> {{ $p->name }}</a>
                                        </h6>

                                    </div>
                                </div>
                                @if ($p->id == auth()->user()->project_id)
                                    <i data-feather='check'></i>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </li> --}}
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name fw-bolder">{{auth()->user()->name}}</span>
                        <span class="user-status">Admin</span>
                    </div>
                    <span class="avatar">
                        <img class="round" src="{{asset('assets/images/portrait/small/avatar-s-11.jpg')}}" alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{route('profile.edit')}}"><i class="me-50" data-feather="user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:;"><i class="me-50" data-feather="settings"></i> Settings</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="me-50" data-feather="power"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- END: Header-->
