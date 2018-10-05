
var featherEditor = new Aviary.Feather({
   apiKey: $('input[name="_aviary"]').val(),
   tools: 'crop,resize,orientation,enhance,effects,brightness,contrast',
   cropPresets: [
      ['Custom','Custom'],
      ['Portrait','2:3'],
   ],
   displayImageSize: true,
   noCloseButton: false,
   onReady: function() {
      $('#person-poster').addClass('img-responsive');
   },
   onSave: function(imageID, newUrl) {
      $.ajax({
         type: "POST",
         url: '/aviary',
         dataType : "json",
         data: {
            _token: $('meta[name="_token"]').attr('content'),
            img: newUrl,
            src: $('#person-poster').attr('src'),
            dest: "people"
         }
     }).done(function(json) {
        console.log(json.err);
        $('#person-poster').prop("src", json.src+"?"+json.time);
        featherEditor.close();
     });
   }
});

$(document).ready(function() {

   $('#movieTabs a').click(function (e) {
     e.preventDefault();
     $(this).tab('show');
  });

   $('.input-group.date').datepicker({
      format: "dd-mm-yyyy",
      orientation: "bottom auto",
      autoclose: true,
      todayHighlight: true
   });

   $('#movie_list').selectize();

   $('#delete_person').click(function() {
      $('#delete_person_form').submit();
   });

   $('.modal').on('hide.bs.modal', function(e) {
      $('.modal .form-control').val('');
      setMovieId('');
      clearCheckboxes();
      clearErrorMessages();
      clearModalSelectize();
   });

   $('#add_new_role').click(function() {
      $.ajax({
         type: 'POST',
         url: '/addNewRole',
         data: {
            _token: $('meta[name="_token"]').attr('content'),
            person: $('#person_id').val(),
            movie: $('#movie_id').val(),
            character: $('#character_name').val(),
            star: $('#main_star').is(':checked') ? 1 : 0
         }
      }).done(function(html) {
         var selectize = $("#movie_list")[0].selectize;
         selectize.removeOption($('#person_id').val());
         $('#role-list').html(html);
         $('.modal').modal('hide');
      });
   });

   $('#edit_new_cast').click(function() {
      $.ajax({
         type: 'POST',
         url: '/editRole',
         data: {
            _token: $('meta[name="_token"]').attr('content'),
            person: $('#person_id').val(),
            movie: $('#movie_id').val(),
            character: $('#edit_character_name').val(),
            star: $('#main_actor').is(':checked') ? 1 : 0
         }
      }).done(function(html) {
         $('#role-list').html(html);
         $('.modal').modal('hide');
      });
   });

   $('#remove_role').click(function() {
      $.ajax({
         type: 'POST',
         url: '/removeRole',
         data: {
            _token: $('meta[name="_token"]').attr('content'),
            person: $('#person_id').val(),
            movie: $('#movie_id').val(),
         }
      }).done(function(html) {
         $('#role-list').html(html);
         $('.modal').modal('hide');
      });
   });

});

function launchEditor() {
   $('#person-poster').removeClass('img-responsive');
   featherEditor.launch({
      image:  'person-poster'
   });
   return false;
}

function addMovieRole() {
   $('#new-role-modal').modal();
}

function editMovieRole(castID) {
   $.ajax({
      type: 'POST',
      url: '/getCastDetails',
      data: {
         _token: $('meta[name="_token"]').attr('content'),
         cast_id: castID
      }
   }).done(function(json) {
      $('#main_actor').prop('checked', json.star);
      $('#edit_character_name').val($('<textarea/>').html(json.character).text());
      $('#movie_id').val(json.movie_id);
      $('#edit-cast-modal').modal();
   });
}

function removeMovieRole(id) {
   setMovieId(id);
   $('#remove-role-modal').modal();
}

function setMovieId(id) {
   $('#movie_id').val(id);
}

function clearModalSelectize() {
   var $select = $('.modal select').selectize();
   $select.each(function(index, value) {
      var control = $select[index].selectize;
      control.clear();
   });
}

function clearCheckboxes() {
   $('#main_star').prop('checked', false);
   $('#main_actor').prop('checked', false);
}

function clearErrorMessages() {
   $('div.form-group').removeClass('has-error');
   $('[id$=_error]').addClass('hide');
   $('[id$=error_message]').html('');
}


function addPosition() {
    $('#new-position-modal').modal();
}

$('#add_new_position').click(function() {
    $.ajax({
        type: 'POST',
        url: '/addNewPosition',
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            person: $('#person_id').val(),
            movie: $('#movie_id').val(),
            position: $('#crew_position').val(),
        }
    }).done(function(html){
        // var selectize = $("#crew_list")[0].selectize;
        $('#position-list').html(html);
        $('#new-position-modal').modal('hide');
    });
});

function editPosition(crewID) {
    $.ajax({
        type: 'POST',
        url: '/getCrewDetails',
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            crew_id: crewID
        }
    }).done(function(json){
        $('#edit_position_name').val($('<textarea/>').html(json.position).text());
        $('#person_id').val(json.person_id);
        $('#movie_id').val(json.movie_id);
        $('#crew_id').val(json.crew_id);
        $('#edit-position-modal').modal();
    });
}

$('#update_position').click(function() {
    $.ajax({
        type: 'POST',
        url: '/editPosition',
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            person: $('#person_id').val(),
            movie: $('#movie_id').val(),
            position: $('#new_crew_position').val(),
            crew_id: $('#crew_id').val(),
        }
    }).done(function(html){
        $('#position-list').html(html);
        $('#edit-position-modal').modal('hide');
    });
});



function removeCrewMovie(id) {
    setRowId(id);
    $('#remove-crew-modal').modal();
}



$('#remove_crew').click(function(){
    $.ajax({
        type: 'POST',
        url: '/removePosition',
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            row: $('#row_id').val(),
            person: $('#person_id').val(),
        }
    }).done(function(html){
        $('#position-list').html(html);
        $('#remove-crew-modal').modal('hide');
    });
});

function setRowId(id) {
    $('#row_id').val(id);
}

function showModal(type, id) {
   var route = "";
   switch(type) {
      // case "createPosition" : route = "createPersonPosition";  break;
      // case "editPosition"   : route = "editPersonPosition";    break;
      // case "removePosition" : route = "destroyPersonPosition"; break;
   }
   $.ajax({
      type: 'POST',
      url: '/' + route,
      data: {
         _token: $('meta[name="_token"]').attr('content'),
         id: id
      }
   }).done(function(html) {
      $('#empty-modal').html(html).modal();
      $('#alert-messages').remove();
   });
}
