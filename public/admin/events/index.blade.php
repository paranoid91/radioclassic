<div style="margin-bottom:10px;" id="event_desc">
    <span style="cursor:pointer;background:#ccc;color:#fff;padding:5px 10px;">Out of date Events</span>
    <span style="cursor:pointer;background:#3a87ad;color:#fff;padding:5px 10px;">Current Events</span>
    <span style="cursor:pointer;background:#c09;color:#fff;padding:5px 10px;">Future Events</span>
    <span style="cursor:pointer;background:green;color:#fff;padding:5px 10px;">My Events</span>
</div>
<div id="eventDisplay"></div>
<div id='loading'>loading...</div>

<div id='calendar'></div>
<link rel="stylesheet" href="{{ asset('/js/events/fullcalendar.css') }}"/>
<script src="{{ asset('/js/events/moment.min.js') }}"></script>
<script src="{{ asset('/js/events/fullcalendar.js?ver='.rand(0,99999)) }}"></script>
<script>

    $(document).ready(function() {

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '{{date('Y-m-d')}}',
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            firstHour:'00:00:00',
            dayClick: function(date, jsEvent, view) {
                //document.location.href = '/apanel/index.php?component=article&section=add&Y='+date.format('YYYY')+'&M='+date.format('MM')+'&D='+date.format('DD')+'&H='+date.format('HH')+'&I='+date.format('mm');
                $("#EventModal").modal('toggle');
                $('input[name="start_time"]').val(date.format('DD/MM/YYYY HH:mm'));
                $('input[name="end_time"]').val(date.format('DD/MM/YYYY HH:mm'));
            },
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: '{{action("Admin\\ArticlesController@getEvents")}}',
                    dataType: 'json',
                    type:'POST',
                    data: {
                        // our hypothetical feed requires UNIX timestamps
                        start: start.unix(),
                        end: end.unix(),
                        _method:'POST',
                        _token:'{{csrf_token()}}'
                    },
                    success: function(doc) {
                        if(doc == 0){
                            $('#loading').hide();
                        }else{
                            var events = doc;
                            //console.log(doc);
                            callback(events);
                        }
                    }
                });

            },
            loading: function(bool) {
                $('#loading').toggle(bool);
            },
            eventClick: function(event,element) {
                    if(element.toElement.getAttribute('class') == 'fc-bg'){
                        $('#EventReadModal .modal-title').html(event.title);
                        $('#EventReadModal .modal-body').html(event.body);
                        $('#EventReadModal').modal('toggle');
                    }else{
                        $('#calendar').fullCalendar('gotoDate', event.start);
                        $('#calendar').fullCalendar('changeView', 'agendaDay');
                    }

            }
        });



    });

    var addEventRecords = function(e){
        var error = false;
        var route = e.attr('data-route');
        var token = e.attr('data-token');
        var start = e.find('input[name="start_time"]');
        var end = e.find('input[name="end_time"]');
        var person = e.find('select[name="person"]');
        var title = e.find('input[name="title"]');
        var text = e.find('textarea[name="text"]');
        if(start.val() != ""){
            start.css('border','1px solid #CCC');
        }else{
            start.css('border','1px solid red');
            error = true;
        }
        if(start.val() > end.val()){
            start.css('border','1px solid red');
            end.css('border','1px solid red');
            error = true;
        }
        if(title.val() != ""){
            start.css('border','1px solid #CCC');
        }else{
            start.css('border','1px solid red');
            error = true;
        }
        if(error == false){
            $.ajax({
                url:route,
                type:'post',
                data:{_method:'POST',_token:token,title:title.val(),body:text.val(),published_at:start.val(),finished_at:end.val(),user_id:person.val(),cat:66},
                success:function(request){
                    $("#EventModal").modal("toggle");
                    location.reload();
                }
            });
        }else{
            return false;
        }
    }
</script>