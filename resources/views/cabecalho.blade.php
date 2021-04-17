<div class="jumbotron">
	<a href="navbar.php"> <h1 class="display-6"  class="Responsive"><img src="/imagens/logo.jpg" alt="logocps2" /> </h1> </a>
   <h4><p class="lead">Sistema de HelpDesk -  UGAF </p></h4>
	<hr class="my-0">
    @include('scripts');

   <?php

   	if(!isset($_SESSION))
    {
        session_start();
    }
    ?>

</div>
