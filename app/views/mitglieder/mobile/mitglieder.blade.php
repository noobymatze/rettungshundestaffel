@extends('layouts.mobile-navigation')

@section('header-center')
	<h1>Mitglieder</h1>
@stop
@section('content')
	<p>Ich</p>
	<style>
	.user-list>li {
		overflow: visible;
		display: block;
		position: relative;
		overflow: visible;
	}
	.user-list>li>a {
		display: block;
		position: relative;
		overflow: hidden;
		margin: 0;
		min-height: 3.625em;
		padding: .7em 3.5em .7em 6.25em;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.user-list>li>a>i {
		right: .5625em;
		font-size: 1em;
		top: 50%;
		margin-top: -1em;
		position: absolute;
	}
	.user-list>li>a>img {
		position: absolute;
		max-height: 5em;
		min-height: 5em;
		left: 0;
		top: 0;
	}
	.user-list>li>a>h2 {
		font-size: 1em;
		margin: .45em 0;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.user-list>li>a>p {
		font-size: .75em;
		margin: .6em 0;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.user-list, .user-list>li {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	</style>
	<ul class="user-list">
		@foreach ($others as $user)
			<li>
				<a>
					<img class="pure-img" src="http://placehold.it/100x100">
					<h2>{{{ $user->vollerName() }}}</h2>
					<p>Telefon: {{{ $user->telefon or '-' }}}</p>
					<i class="icon-th-large"></i>
				</a>
			</li>
		@endforeach
	</ul>

	<!--<ul data-role="listview" data-inset="true">
    <li><a href="#">
        <img src="http://1.1.1.4/bmi/demos.jquerymobile.com/1.4.3/_assets/img/album-bb.jpg">
    <h2>Broken Bells</h2>
    <p>Broken Bells</p></a>
    </li>
    <li><a href="#">
        <img src="http://1.1.1.1/bmi/demos.jquerymobile.com/1.4.3/_assets/img/album-hc.jpg">
    <h2>Warning</h2>
    <p>Hot Chip</p></a>
    </li>
    <li><a href="#">
        <img src="http://1.1.1.3/bmi/demos.jquerymobile.com/1.4.3/_assets/img/album-p.jpg">
    <h2>Wolfgang Amadeus Phoenix</h2>
    <p>Phoenix</p></a>
    </li>
</ul>-->
@stop