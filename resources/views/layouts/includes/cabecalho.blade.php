<header>
	<a href="#!">
		<img class="display-6" class="Responsive" src=" {{ asset('/imagens/logo.jpg') }}" alt="logo" />
	</a>
	<h4>
		<p class="lead">Sistema de HelpDesk - UGAF </p>
	</h4>
	<hr class="my-0">

	@if($admin = true)
		@include('layouts.includes.navbar_admin')
	@else
		@include('layouts.includes.navbar_user')
	@endif
</header>

<div class="w-100">
    <x-flash-messages/>
</div>
