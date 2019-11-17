<header>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  	<a class="navbar-brand" href="#">Tracking bag</a>
  	<img id="profile_picture" src="assets/images/{$customer['customerId']}.png" alt="User photo" class="rounded-circle d-inline-block align-top">
  	<span id="profile_name" class="text-white">{$customer['name']}</span> 
	  <button
	  	class="navbar-toggler"
	  	type="button"
	  	data-toggle="collapse"
	  	data-target="#header_navbar"
	  	aria-controls="header_navbar"
	  	aria-expanded="false"
	  	aria-label="Toggle navigation"
	  >
	    <span class="navbar-toggler-icon"></span>
	  </button>

		<div class="collapse navbar-collapse" id="header_navbar">
	    <div class="navbar-nav ml-auto">
	      <a class="nav-item nav-link" href="/">Home</a>
	      <a class="nav-item nav-link" href="/trackbag">Track your bag</a>
	      <a class="nav-item nav-link" href="/incidences">Incidences</a>
	    </div>
		</div>
  </nav>
  <input hidden type="hidden" class="complaint_data" id="customerId" value="{$customer['customerId']}">
  <input hidden type="hidden" class="complaint_data" id="customerName" value="{$customer['name']}">
</header>