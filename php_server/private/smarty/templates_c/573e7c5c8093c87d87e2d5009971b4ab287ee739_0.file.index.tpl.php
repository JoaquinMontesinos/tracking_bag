<?php
/* Smarty version 3.1.32, created on 2019-11-17 01:13:16
  from '/volume1/webs/taxiyecla.com/private/smarty/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5dd0909c204751_79777105',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '573e7c5c8093c87d87e2d5009971b4ab287ee739' => 
    array (
      0 => '/volume1/webs/taxiyecla.com/private/smarty/templates/index.tpl',
      1 => 1573933920,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:general_head.tpl' => 1,
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
    'file:general_foot.tpl' => 1,
  ),
),false)) {
function content_5dd0909c204751_79777105 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
	<head>
		<?php $_smarty_tpl->_subTemplateRender("file:general_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    	</head>

  <body>
    <?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <main class="container">
      <h1>Flights</h1>
      <ul class="list-group">
        <a href="/trackbag" title="">
          <li class="list-group-item">Flight to <?php echo $_smarty_tpl->tpl_vars['customer']->value['target'];?>
</li>
        </a>
      </ul>
      <br>
      <br>
    </main>
    <?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  </body>

	<?php $_smarty_tpl->_subTemplateRender("file:general_foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</html><?php }
}
