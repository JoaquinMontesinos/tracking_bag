<?php
/* Smarty version 3.1.32, created on 2019-11-17 01:13:09
  from '/volume1/webs/taxiyecla.com/private/smarty/templates/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5dd09095d23906_15789372',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0ead44bdaadbfb2c930cd2628076ad72e1ef4716' => 
    array (
      0 => '/volume1/webs/taxiyecla.com/private/smarty/templates/header.tpl',
      1 => 1573942478,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd09095d23906_15789372 (Smarty_Internal_Template $_smarty_tpl) {
?><header>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  	<a class="navbar-brand" href="#">Tracking bag</a>
  	<img id="profile_picture" src="assets/images/<?php echo $_smarty_tpl->tpl_vars['customer']->value['customerId'];?>
.png" alt="User photo" class="rounded-circle d-inline-block align-top">
  	<span id="profile_name" class="text-white"><?php echo $_smarty_tpl->tpl_vars['customer']->value['name'];?>
</span> 
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
  <input hidden type="hidden" class="complaint_data" id="customerId" value="<?php echo $_smarty_tpl->tpl_vars['customer']->value['customerId'];?>
">
  <input hidden type="hidden" class="complaint_data" id="customerName" value="<?php echo $_smarty_tpl->tpl_vars['customer']->value['name'];?>
">
</header><?php }
}
