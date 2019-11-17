<?php
/* Smarty version 3.1.32, created on 2019-11-17 01:47:54
  from '/volume1/webs/taxiyecla.com/private/smarty/templates/trackbag.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5dd098baa51778_44877084',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f130a991cb60221b8b05b47c3f48e5007174cb9' => 
    array (
      0 => '/volume1/webs/taxiyecla.com/private/smarty/templates/trackbag.tpl',
      1 => 1573948224,
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
function content_5dd098baa51778_44877084 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/volume1/webs/taxiyecla.com/private/smarty-3.1.32/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?><!DOCTYPE html>
<html lang="en">
  <head>
    <?php $_smarty_tpl->_subTemplateRender("file:general_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php echo '<script'; ?>
 async src="assets/js/trackbag.js"><?php echo '</script'; ?>
>
  </head>

  <body>
    <?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <main class="container">
      <h1>Flight to: <?php echo $_smarty_tpl->tpl_vars['customer']->value['target'];?>
</h1>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['baggages']->value, 'data', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['data']->value) {
?>
        
        <h3>Baggage <?php echo $_smarty_tpl->tpl_vars['id']->value+1;?>
</h3>
        <ul class="list-group">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['events'], 'event_data', false, 'event_n');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['event_n']->value => $_smarty_tpl->tpl_vars['event_data']->value) {
?>
            <?php switch ($_smarty_tpl->tpl_vars['event_data']->value['type']){
case 'CHECKED_IN':?>
                <?php $_smarty_tpl->_assignInScope('class', '');?> 
                <?php $_smarty_tpl->_assignInScope('fa_icon', 'clipboard-check');?> 
              <?php break 1;?>
              <?php case 'LOADED':?>
                <?php $_smarty_tpl->_assignInScope('class', '');?> 
                <?php $_smarty_tpl->_assignInScope('fa_icon', 'plane-departure');?> 
              <?php break 1;?>
              <?php case 'UNLOADED':?>
                <?php $_smarty_tpl->_assignInScope('class', '');?> 
                <?php $_smarty_tpl->_assignInScope('fa_icon', 'plane-arrival');?> 
              <?php break 1;?>
              <?php case 'CLAIMED':?>
                <?php $_smarty_tpl->_assignInScope('class', 'list-group-item-success');?> 
                <?php $_smarty_tpl->_assignInScope('fa_icon', 'luggage-cart');?> 
              <?php break 1;?>
              <?php case 'MISSING':?>
                <?php $_smarty_tpl->_assignInScope('class', 'list-group-item-warning');?> 
                <?php $_smarty_tpl->_assignInScope('fa_icon', 'exclamation-circle');?>
              <?php break 1;?>
              <?php case 'DAMAGED':?>
                <?php $_smarty_tpl->_assignInScope('class', 'list-group-item-danger');?> 
                <?php $_smarty_tpl->_assignInScope('fa_icon', 'times-circle');?> 
              <?php break 1;?>
            <?php }?>
            <li class="list-group-item <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
              <i class="fas fa-<?php echo $_smarty_tpl->tpl_vars['fa_icon']->value;?>
"></i>
              <?php if ($_smarty_tpl->tpl_vars['event_data']->value['type'] === 'MISSING') {?>
                Marked as 
              <?php }?>
              <?php echo ucfirst($_smarty_tpl->tpl_vars['event_data']->value['type']);?>

              in <?php echo $_smarty_tpl->tpl_vars['event_data']->value['airport'];?>

              at <?php echo $_smarty_tpl->tpl_vars['event_data']->value['timestamp'];?>

              <?php if ($_smarty_tpl->tpl_vars['event_data']->value['type'] === 'MISSING' || $_smarty_tpl->tpl_vars['event_data']->value['type'] === 'DAMAGED') {?>
                <a href="incidences" class="alert-link">Go to incidences</a>
              <?php }?>
              <?php if ($_smarty_tpl->tpl_vars['event_data']->value['type'] === 'CLAIMED') {?>
                <a class="not_found btn btn-warning" href="#" role="button">Baggage not found<i class="fas fa-exclamation-triangle"></i></a>

                <input hidden class="not_found_data" type="hidden" id="customerId" value="<?php echo $_smarty_tpl->tpl_vars['customer']->value['customerId'];?>
">
                <input hidden class="not_found_data" type="hidden" id="last_seen_date" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['event_data']->value['timestamp'],"%Y-%m-%d %H:%M:%S");?>
">
                <input hidden class="not_found_data" type="hidden" id="last_seen_city" value="<?php echo $_smarty_tpl->tpl_vars['event_data']->value['airport'];?>
">
                <input hidden class="not_found_data" type="hidden" id="missing_bag_city" value="<?php echo $_smarty_tpl->tpl_vars['customer']->value['target'];?>
">
                <input hidden class="not_found_data" type="hidden" id="missing_bag_date" value="<?php echo smarty_modifier_date_format('now',"%Y-%m-%d %H:%M:%S");?>
">
                <input hidden class="not_found_data" type="hidden" id="baggageId" value="<?php echo $_smarty_tpl->tpl_vars['event_data']->value['baggageId'];?>
">
              <?php }?>
            </li>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </ul>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <br>
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
