<form method="post" onsubmit="addEventRecords($(this));return false;" data-token="{{csrf_token()}}"  data-route="{{ action('Admin\ArticlesController@event') }}">
    <input type="hidden" name="lang" value="{{App::getLocale()}}">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Start Time</label>
                <input type="text" name="start_time" id="datetimepicker1" class="form-control">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>End Time</label>
                <input type="text" name="end_time" id="datetimepicker2" class="form-control">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Chose Dj</label>
                <select name="person" class="form-control" style="margin-top:0;">
                    <option>---</option>
                    @if(count($users) > 0)
                    @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" value="" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Text</label>
                <textarea name="text" class="form-control" rows="5"></textarea>
            </div>
        </div>
    </div>
    <input type="submit" name="save" id="save_event" style="display:none">
</form>
