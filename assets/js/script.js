$(document).ready(function() {
  $("#table_data").dataTable();
});

$(".alert-success, .alert-danger, .alert-warning").fadeTo(5000, 1000).slideUp(1000, function(){
    $(".alert-success, .alert-danger, .alert-warning").slideUp(1000);
});

$(document).ready(function () {
  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = true;

    trigger.click(function () {
      hamburger_cross();      
    });

    function hamburger_cross() {

      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {   
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  
  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
  });  
});


  $(document).ready(function() {
      $(".select2").select2({
          allowClear: true
      });
  });

     // disabling dates
  var startDate = new Date();
  var endDate = new Date() + 7;
  $('#dp_awal').datepicker().on('changeDate', function(ev) {
      if (ev.date.valueOf() > endDate.valueOf()) {
          $('#alert').show().find('strong').text('Tanggal awal tidak boleh melebihi tanggal akhir');
      } else {
          $('#alert').hide();
          startDate = new Date(ev.date);
          $('#startDate').text($('#dp_awal').data('date'));
      }
      $('#dp_awal').datepicker('hide');
  });
  $('#dp_akhir').datepicker().on('changeDate', function(ev) {
      if (ev.date.valueOf() < startDate.valueOf()) {
          $('#alert').show().find('strong').text('Tanggal awal tidak boleh melebihi tanggal akhir');
      } else {
          $('#alert').hide();
          endDate = new Date(ev.date);
          $('#endDate').text($('#dp_akhir').data('date'));
      }
      $('#dp_akhir').datepicker('hide');
  });

  $(function() {
      $("[rel='tooltip']").tooltip();
  });
  $('a.media').media({
      width: 550,
      height: 400
  });
  jQuery(document).ready(function($) {
      $('a[class~=facebox]').facebox()
  })

  $(".alert").alert();

  $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      "setDate": new Date(),
      "autoclose": true
  });