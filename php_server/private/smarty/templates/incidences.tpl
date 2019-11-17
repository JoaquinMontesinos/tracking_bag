<!DOCTYPE html>
<html lang="en">
  <head>
    {include file="general_head.tpl"}

    {*JS y CSS personalizados*}
    <script async src="assets/js/incidences.js"></script>
  </head>

  <body>
    {include file="header.tpl"}
    <main class="container">
      <h1>Incidences</h1>
      {if empty($events)===true}
        No new incidences 🙂
      {/if}
      {foreach $events as $event_n => $event_data}
        {if $event_data['event']==='MISSING'}
          <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Missed bag, ID: {$event_data['id']}</h4>
            <p>
              We have detected your missed bag and we have found it.
              It was missed in some point between {$event_data['last_seen_city']} airport at {$event_data['last_seen_date']} and {$event_data['missing_bag_city']} at {$event_data['missing_bag_date']} airport. 
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
          <input type="hidden" id="last_seen_date" value="{$event_data['last_seen_date']}">
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
                  <video controls autobuffer>
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
        {else}
          <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Your bag was damaged, ID: {$event_data['id']}</h4>
            <p>
              It happened on some point between {$event_data['last_seen_city']} airport at {$event_data['last_seen_date']} and {$event_data['missing_bag_city']} airport at {$event_data['missing_bag_date']}.<br>
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
                  <video controls autobuffer>
                    <source src="assets/videos/to_plane.webm" type='video/webm'>
                    <source src="assets/videos/to_plane.mp4" type='video/mp4'>
                    Sorry, your browser doesn't support embedded videos.
                  </video>
                  <video controls autobuffer>
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
        {/if}
        <input hidden class="complaint_data" type="hidden" id="last_seen_date" value="{$event_data['last_seen_date']}">
        <input hidden class="complaint_data" type="hidden" id="baggageId" value="{$event_data['baggageId']}">
        <input hidden class="complaint_data" type="hidden" id="baggageId" value="{$event_data['missing_bag_city']}">
        <input hidden class="complaint_data" type="hidden" id="baggageId" value="{$event_data['missing_bag_date']}">
        <input hidden class="complaint_data" type="hidden" id="eventType" value="{$event_data['event']}">

        <input hidden type="hidden" id="incidentId" value="{$event_data['id']}">
      {/foreach}
      <br>
      <br>
    </main>
    {include file="footer.tpl"}
  </body>

  {include file="general_foot.tpl"}
</html>