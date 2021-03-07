<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MSIS</title>

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.min.css')}}"> -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">

    <style>
        .customer-box {
            padding: 10px 15px 20px;
            border: 1px solid #d6d6d9;
            background-color: #f4f4f5;
        }
    </style>

</head>
<body class="app sidebar-mini pace-done">
    <div id="app">
        <header class="app-header"><a class="app-header__logo" href="#">MSIS</a>
            <!-- Sidebar toggle button-->
            <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
            <!-- Navbar Right Menu-->
            <ul class="app-nav">
                <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                    <ul class="dropdown-menu settings-menu dropdown-menu-right">
                        <!-- <li><a class="dropdown-item" href="#"> <i class="fa fa-cog fa-lg"></i>Settings </a></li>
                        <li><router-link :to="{ name: 'password_change'}" class="dropdown-item"><i class="fa fa-user fa-lg"></i>Profile</router-link></li> -->
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>

                        <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </ul>
                </li>
            </ul>
        </header>
        <!-- Sidebar menu-->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar">
            <div class="app-sidebar__user">
                <img class="app-sidebar__user-avatar" src="{{ url('site-data/logo.jpg') }}" height="40" width="40" alt="User Image">
                <div>
                    <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
                    <p class="app-sidebar__user-designation">{{Auth::user()->email}}</p>
                </div>
            </div>
            <side-menu></side-menu>
        </aside>
        <main class="app-content">
            <router-view></router-view>
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
</body>
</html>
