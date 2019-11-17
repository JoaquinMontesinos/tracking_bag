<!DOCTYPE html>
<html lang="en">
  <head>
    {include file="general_head.tpl"}

    {*JS personalizado*}
    <script async src="assets/js/trackbag.js"></script>
  </head>

  <body>
    {include file="header.tpl"}
    <main class="container">
      <h1>Flight to: {$customer['target']}</h1>
      {*$baggages*}
      {foreach $baggages as $id => $data}
        
        <h3>Baggage {$id+1}</h3>
        <ul class="list-group">
          {foreach $data['events'] as $event_n => $event_data}
            {switch $event_data['type']}{case 'CHECKED_IN'}
                {$class = ''} 
                {$fa_icon = 'clipboard-check'} 
              {break}
              {case 'LOADED'}
                {$class = ''} 
                {$fa_icon = 'plane-departure'} 
              {break}
              {case 'UNLOADED'}
                {$class = ''} 
                {$fa_icon = 'plane-arrival'} 
              {break}
              {case 'CLAIMED'}
                {$class = 'list-group-item-success'} 
                {$fa_icon = 'luggage-cart'} 
              {break}
              {case 'MISSING'}
                {$class = 'list-group-item-warning'} 
                {$fa_icon = 'exclamation-circle'}
              {break}
              {case 'DAMAGED'}
                {$class = 'list-group-item-danger'} 
                {$fa_icon = 'times-circle'} 
              {break}
            {/switch}
            <li class="list-group-item {$class}">
              <i class="fas fa-{$fa_icon}"></i>
              {if $event_data['type']==='MISSING'}
                Marked as 
              {/if}
              {$event_data['type']|ucfirst}
              in {$event_data['airport']}
              at {$event_data['timestamp']}
              {if $event_data['type']==='MISSING' or $event_data['type']==='DAMAGED'}
                <a href="incidences" class="alert-link">Go to incidences</a>
              {/if}
              {if $event_data['type']==='CLAIMED'}
                <a class="not_found btn btn-warning" href="#" role="button">Baggage not found<i class="fas fa-exclamation-triangle"></i></a>

                <input hidden class="not_found_data" type="hidden" id="customerId" value="{$customer['customerId']}">
                <input hidden class="not_found_data" type="hidden" id="last_seen_date" value="{$event_data['timestamp']|date_format:"%Y-%m-%d %H:%M:%S"}">
                <input hidden class="not_found_data" type="hidden" id="last_seen_city" value="{$event_data['airport']}">
                <input hidden class="not_found_data" type="hidden" id="missing_bag_city" value="{$customer['target']}">
                <input hidden class="not_found_data" type="hidden" id="missing_bag_date" value="{'now'|date_format:"%Y-%m-%d %H:%M:%S"}">
                <input hidden class="not_found_data" type="hidden" id="baggageId" value="{$event_data['baggageId']}">
              {/if}
            </li>
          {/foreach}
        </ul>
      {/foreach}
      <br>
      <br>
      <br>
    </main>
    {include file="footer.tpl"}
  </body>

  {include file="general_foot.tpl"}
</html>