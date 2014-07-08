@extends('layouts.mobile-html-skeleton')

@section('body')
	@section('header')
		<header class="pure-g">
		    <div class="pure-u-1-5">
		    	links
		    	@yield('header-left')
		    </div>
		    <div class="pure-u-3-5">
		    	Dashboard
		    	@yield('header-center')
		    </div>
		    <div class="pure-u-1-5">
		    	rechts
		    	@yield('header-right')
		    </div>
		</header>
	@show
	@yield('content')
	@section('nav-bar')
		<nav id="nav-bar">
			<a href="#" class="{{{ $menu == MenuEnum::DASHBOARD ? 'active' : '' }}}">
				<i class="icon-th-large"></i>
				<p>Dashboard</p>
			</a>
			<a href="#" class="{{{ $menu == MenuEnum::TERMINE ? 'active' : '' }}}">
				<i class="icon-calendar"></i>
				<p>Termine</p>
			</a>
			<a href="#" class="{{{ $menu == MenuEnum::MITGLIEDER ? 'active' : '' }}}">
				<i class="icon-users"></i>
				<p>Mitglieder</p>
			</a>
			<a href="#" class="{{{ $menu == MenuEnum::SUCHGEBIETE ? 'active' : '' }}}">
				<i class="icon-map"></i>
				<p>Suchgebiete</p>
			</a>
			<a href="#" class="{{{ $menu == MenuEnum::WEITERES ? 'active' : '' }}}">
				<i class="icon-ellipsis"></i>
				<p>Weiteres</p>
			</a>
		</nav>
	@show
@stop