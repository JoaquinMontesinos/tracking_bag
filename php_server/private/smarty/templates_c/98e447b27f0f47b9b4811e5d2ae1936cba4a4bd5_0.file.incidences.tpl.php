<?php
/* Smarty version 3.1.32, created on 2019-11-17 01:13:09
  from '/volume1/webs/taxiyecla.com/private/smarty/templates/incidences.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5dd09095c93a65_73133286',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '98e447b27f0f47b9b4811e5d2ae1936cba4a4bd5' => 
    array (
      0 => '/volume1/webs/taxiyecla.com/private/smarty/templates/incidences.tpl',
      1 => 1573948595,
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
function content_5dd09095c93a65_73133286 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
  <head>
    <?php $_smarty_tpl->_subTemplateRender("file:general_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php echo '<script'; ?>
 async src="assets/js/incidences.js"><?php echo '</script'; ?>
>
  </head>

  <body>
    <?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <main class="container">
      <h1>Incidences</h1>
      <?php if (empty($_smarty_tpl->tpl_vars['events']->value) === true) {?>
        No new incidences 🙂
      <?php }?>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['events']->value, 'event_data', false, 'event_n');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['event_n']->value => $_smarty_tpl->tpl_vars['event_data']->value) {
?>
        <?php if ($_smarty_tpl->tpl_vars['event_data']->value['event'] === 'MISSING') {?>
          <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Missed bag, ID: <?php echo $_smarty_tpl->tpl_vars['event_data']->value['id'];?>
</h4>
            <p>
              We have detected your missed bag and we have found it.
              It was missed in some point between <?php echo $_smarty_tpl->tpl_vars['event_data']->value['last_seen_city'];?>
 airport at <?php echo $_smarty_tpl->tpl_vars['event_data']->value['last_seen_date'];?>
 and <?php echo $_smarty_tpl->tpl_vars['event_data']->value['missing_bag_city'];?>
 at <?php echo $_smarty_tpl->tpl_vars['event_data']->value['missing_bag_date'];?>
 airport. 
              It will be found and returned as soon as possible. You can see the moment were it was lost (if available in your country) and indicate if you have already recovered it. <br>
              If your baggage was stolen, please follow this link: <a href="https://www.caa.co.uk/Passengers/Resolving-travel-problems/How-the-CAA-can-help/How-to-make-a-complaint/">How to file a complaint</a>
            </p>
            <p class="mb-0">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal1">
                See video
              </button>
              <a href="#" class="recovered btn btn-primary" tabindex="-1" role="button" aria-disabled="true">I have recovered my baggage</a>
            </p>
          </div>
          <input type="hidden" id="last_seen_date" value="<?php echo $_smarty_tpl->tpl_vars['event_data']->value['last_seen_date'];?>
">
          <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Label" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modal1Label">Missing Video</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-center align-content-center">
                  <video controls autoplay autobuffer>
                    <source src="assets/videos/stolen.webm" type='video/webm'>
                    <source src="assets/videos/stolen.mp4" type='video/mp4'>
                    Sorry, your browser doesn't support embedded videos.
                  </video>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        <?php } else { ?>
          <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Your bag was damaged, ID: <?php echo $_smarty_tpl->tpl_vars['event_data']->value['id'];?>
</h4>
            <p>
              It happened on some point between <?php echo $_smarty_tpl->tpl_vars['event_data']->value['last_seen_city'];?>
 airport at <?php echo $_smarty_tpl->tpl_vars['event_data']->value['last_seen_date'];?>
 and <?php echo $_smarty_tpl->tpl_vars['event_data']->value['missing_bag_city'];?>
 airport at <?php echo $_smarty_tpl->tpl_vars['event_data']->value['missing_bag_date'];?>
.<br>
              You can see the moment were it was damaged</a> (if available in your country) and complain to the airline.
            </p>
            <p class="mb-0"> 
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                See videos or follow steps
              </button>
              <a href="#" class="complaint btn btn-primary" tabindex="-1" role="button" aria-disabled="true">Complaint</a>
            </p>
          </div>
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Damage Video</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-center align-content-center">
                  <video controls autoplay autobuffer>
                    <source src="assets/videos/to_plane.webm" type='video/webm'>
                    <source src="assets/videos/to_plane.mp4" type='video/mp4'>
                    Sorry, your browser doesn't support embedded videos.
                  </video>
                  <video controls autoplay autobuffer>
                    <source src="assets/videos/throwing_baggage.webm" type='video/webm'>
                    <source src="assets/videos/throwing_baggage1.webm" type='video/webm'>
                    <source src="assets/videos/throwing_baggage.mp4" type='video/mp4'>
                    Sorry, your browser doesn't support embedded videos.
                  </video>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        <?php }?>
        <input hidden class="complaint_data" type="hidden" id="last_seen_date" value="<?php echo $_smarty_tpl->tpl_vars['event_data']->value['last_seen_date'];?>
">
        <input hidden class="complaint_data" type="hidden" id="baggageId" value="<?php echo $_smarty_tpl->tpl_vars['event_data']->value['baggageId'];?>
">
        <input hidden class="complaint_data" type="hidden" id="baggageId" value="<?php echo $_smarty_tpl->tpl_vars['event_data']->value['missing_bag_city'];?>
">
        <input hidden class="complaint_data" type="hidden" id="baggageId" value="<?php echo $_smarty_tpl->tpl_vars['event_data']->value['missing_bag_date'];?>
">
        <input hidden class="complaint_data" type="hidden" id="eventType" value="<?php echo $_smarty_tpl->tpl_vars['event_data']->value['event'];?>
">

        <input hidden type="hidden" id="incidentId" value="<?php echo $_smarty_tpl->tpl_vars['event_data']->value['id'];?>
">
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
