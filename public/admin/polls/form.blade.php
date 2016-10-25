{!! Form::hidden('answers',null) !!}

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('published_at',trans('all.published_at')) !!}
            {!! Form::text('published_at',$date,['class'=>'form-control','id'=>'datetimepicker1']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('title',trans('polls.title')) !!}
            {!! Form::text('title',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div id="answers">

    @if(count($children) > 0)
        {{--*/ $i = 0 /*--}}@foreach($children as $child) {{--*/ $i++ /*--}}
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        {!! Form::label('answer['.$i.']',trans('polls.answer').' '.$i.'') !!}
                        {!! Form::text('answer['.$i.']',$child->title,['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        @endforeach
    @else
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                {!! Form::label('answer[1]',trans('polls.answer').' 1') !!}
                {!! Form::text('answer[1]',null,['class'=>'form-control']) !!}
            </div>
        </div>
    </div>
    @endif
</div>

<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::button('<i class="fa fa-minus"></i> '.trans('polls.remove_last').'',['class' => 'btn btn-danger left','onClick'=>'remField("answers")']) !!}
            {!! Form::button('<i class="fa fa-plus"></i> '.trans('polls.add_answer').'',['class' => 'btn btn-success right','onClick'=>'addField("answers","answer","'.trans('polls.answer').'")']) !!}
            <div class="fix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::submit($submitButtonText,['class' => 'btn btn-primary']) !!}
        </div>
    </div>
</div>
