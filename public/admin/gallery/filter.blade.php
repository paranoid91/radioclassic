<div class="well well-sm filter">

    {!! Form::open(['action'=>'Admin\ImagesController@filter','method'=>'POST','class'=>'form-horizontal']) !!}

    <div class="control-group" style="position:relative;">
        {!! Form::hidden('g_filter',filter_request($request,'g_filter',1)) !!}

        {!! Form::text('g_author',filter_request($request,'g_author'),['class'=>'controls  form-control','style'=>'width:18%','placeholder'=>'ავტორი']) !!}

        {!! Form::text('g_from',filter_request($request,'g_from'),['class'=>'controls form-control','style'=>'width:18%','id'=>'datetimepicker1','placeholder'=>'დან']) !!}

        {!! Form::text('g_to',filter_request($request,'g_to'),['class'=>'controls form-control','style'=>'width:18%','id'=>'datetimepicker2','placeholder'=>'მდე']) !!}

        {!! Form::submit('გაფილტვრა',['class' => 'btn btn-primary btn-default']) !!}

        {!! Form::submit('გაწმენდა',['class' => 'btn btn-danger btn-default','onClick' => '$("input[name=g_to],input[name=g_from],input[name=g_author]").val("");']) !!}
        <div class="fix"></div>
    </div>

    {!! Form::close() !!}

</div>