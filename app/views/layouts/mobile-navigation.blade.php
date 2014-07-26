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
			<a href="{{ URL::action('MDashboardController@renderDashboard') }}" class="@activeOnPath('mobile/dashboard*')">
				<i class="icon-th-large"></i>
				<p>Dashboard</p>
			</a>
			<a href="#" class="@activeOnPath('mobile/termine*')">
				<i class="icon-calendar"></i>
				<p>Termine</p>
			</a>
			<a href="{{ URL::action('MMitgliederController@renderMitglieder') }}" class="@activeOnPath('mobile/mitglieder*')">
				<i class="icon-users"></i>
				<p>Mitglieder</p>
			</a>
			<a href="{{ URL::action('SuchgebieteMobilController@index') }}" class="@activeOnPath('mobile/suchgebiete*')">
				<i class="icon-map"></i>
				<p>Suchgebiete</p>
			</a>
			<a href="{{ URL::action('MWeiteresController@renderWeiteres') }}" class="@activeOnPath('mobile/weiteres')">
				<i class="icon-ellipsis"></i>
				<p>Weiteres</p>
			</a>
		</nav>
	@show
	@yield('content')
@stop