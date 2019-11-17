"use strict";
$(document).ready(function(){

  $('.complaint').on('click', function(event) {
    event.preventDefault();
    let data = {};
    $.each($('.complaint_data'), function(index, node) {
      data[$(node).prop('id')] = $(node).val();
    });
    let data_to_send = {
      'data': data,
      'type': 'sendSMS'
    }
    $.ajax({
      type: "POST",
      url: "webservices/general_webservice",
      data: data_to_send,
      success: function (data){
        console.log(data);
        alert('Complaint sent!\nRedirecting to homepage');
        location='/';
      }
    });
  });

  $('.recovered').on('click', function(event) {
    event.preventDefault();
    let data = {
      incidentId: $(this).data('id')
    };
    let data_to_send = {
      'data': data,
      'type': 'markAsResolved'
    }
    $.ajax({
      type: "POST",
      url: "webservices/general_webservice",
      data: data_to_send,
      success: function (data){
        console.log(data);
        alert('Marked as resolved!\nThis page will reload now');
        location.reload(false);
      }
    });
    
  });

});