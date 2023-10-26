<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    {{-- <div class="mr-3">
                        <a href="#"><img src="global_assets/images/placeholders/placeholder.jpg" width="38" height="38" class="rounded-circle" alt=""></a>
                    </div> --}}

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{Auth::user()->nama}}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-user font-size-sm"></i> &nbsp;{{Auth::user()->role->nama}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Menu</div> <i class="icon-menu" title="Main"></i></li>
                @if (Auth::user()->role_id == 1)
                <li class="nav-item">
                    <a href="{{url('/dashboard')}}" class="nav-link {{ (request()->is('dashboard*')) ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/users')}}" class="nav-link {{ (request()->is('users*')) ? 'active' : '' }}">
                        <i class="icon-users"></i>
                        <span>
                            User
                        </span>
                    </a>
                </li>
                @endif
                @if (in_array(Auth::user()->role_id, [1,20]))
                <li class="nav-item">
                    <a href="{{url('/pasiens')}}" class="nav-link {{ (request()->is('pasiens*')) ? 'active' : '' }}">
                        <i class="icon-users"></i>
                        <span>
                            Pasien
                        </span>
                    </a>
                </li>
                @endif
                @if (Auth::user()->role_id == 1)
                <li class="nav-item">
                    <a href="{{url('/bangsals')}}" class="nav-link {{ (request()->is('bangsals*')) ? 'active' : '' }}">
                        <i class="icon-city"></i>
                        <span>
                            Bangsal
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/ruangs')}}" class="nav-link {{ (request()->is('ruangs*')) ? 'active' : '' }}">
                        <i class="icon-office"></i>
                        <span>
                            Ruang
                        </span>
                    </a>
                </li>
                @endif
                @if (in_array(Auth::user()->role_id, [1, 10, 20]))
                <li class="nav-item">
                    <a href="{{url('/rekam-medis')}}" class="nav-link {{ (request()->is('rekam-medis*')) ? 'active' : '' }}">
                        <i class="icon-archive"></i>
                        <span>
                            Rekam Medis
                        </span>
                    </a>
                </li>
                @endif
                @if (in_array(Auth::user()->role_id, [1, 10, 30]))
                <li class="nav-item">
                    <a href="{{url('/reseps')}}" class="nav-link {{ (request()->is('reseps*')) ? 'active' : '' }}">
                        <i class="icon-file-text"></i>
                        <span>
                            Resep Obat
                        </span>
                    </a>
                </li>
                @endif
                <!-- /main -->
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
