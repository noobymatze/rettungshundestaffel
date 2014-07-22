@extends('layouts.mobile-skeleton')

@section('body')
	@section('header')
		<header id="top-bar" class="pure-g">
		    <div id="top-bar-left" class="pure-u-1-5">
		    	@yield('header-left')
		    </div>
		    <div id="top-bar-center" class="pure-u-3-5">
		    	@yield('header-center')
		    </div>
		    <div id="top-bar-right" class="pure-u-1-5">
		    	@yield('header-right')
		    </div>
		</header>
	@show
	@section('nav-bar')
		<nav id="nav-bar">
			<a href="{{ URL::action('MDashboardController@renderDashboard') }}" class="{{{ $menu == MenuEnum::DASHBOARD ? 'active' : '' }}}">
				<i class="icon-th-large"></i>
				<p>Dashboard</p>
			</a>
			<a href="#" class="{{{ $menu == MenuEnum::TERMINE ? 'active' : '' }}}">
				<i class="icon-calendar"></i>
				<p>Termine</p>
			</a>
			<a href="{{ URL::action('MMitgliederController@renderMitglieder') }}" class="{{{ $menu == MenuEnum::MITGLIEDER ? 'active' : '' }}}">
				<i class="icon-users"></i>
				<p>Mitglieder</p>
			</a>
			<a href="#" class="{{{ $menu == MenuEnum::SUCHGEBIETE ? 'active' : '' }}}">
				<i class="icon-map"></i>
				<p>Suchgebiete</p>
			</a>
			<a href="{{ URL::action('MWeiteresController@renderWeiteres') }}" class="{{{ $menu == MenuEnum::WEITERES ? 'active' : '' }}}">
				<i class="icon-ellipsis"></i>
				<p>Weiteres</p>
			</a>
		</nav>
	@show
	@yield('content')
@stop