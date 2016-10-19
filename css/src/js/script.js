$(document).ready(function(){
  $('#myTable').DataTable( {
    "searching":   false,
    "lengthChange": false,
    "info":     false,
    "pagingType": "numbers",
    "dom": 'rtp'
    // "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
  } );

  $('#myTable')
    .find('.dropdownData')
    .each(function(index, item){
      var text = $(item).text().trim();
      if (text.length > 0){
        $('#testSelect').append('<li role="presentation"><a role="menuitem" tabindex="-1" href="#">' + text + '</a></li>');
      }
        console.log(text);
    });
});