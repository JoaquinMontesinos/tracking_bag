"use strict";
$(document).ready(function(){

  $('.not_found').on('click', function(event) {
    event.preventDefault();
    let data = {};
    $.each($('.not_found_data'), function(index, node) {
      data[$(node).prop('id')] = $(node).val();
    });
    console.log(data);
    let data_to_send = {
      'data': data,
      'type': 'createIncident'
    }
    /**/
    $.ajax({
      type: "POST",
      url: "webservices/general_webservice",
      data: data_to_send,
      success: function (data){
        if(data.todoOK==true){
          console.log(data);
          alert('Your incident have been created!\nRedirecting to Incidences');
          //location='/incidences';
        } else {
          console.log(data);
          alert('Something failed. Please try later');
        }

      }
    });
    
  });

});