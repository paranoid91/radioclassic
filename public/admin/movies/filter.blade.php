<div class="well well-sm filter">

    {!! Form::open(['action'=>'Admin\MoviesController@filter','method'=>'POST','class'=>'form-horizontal']) !!}

        <div class="control-group" style="position:relative;">
            {!! Form::hidden('m_filter',filter_request($request,'m_filter',1)) !!}

            {!! Form::selectChild('m_cat',$cats,filter_request($request,'m_cat'),['class'=>'controls form-control','style'=>'width:18%']) !!}

            {!! Form::text('m_author',filter_request($request,'m_author'),['class'=>'controls  form-control','style'=>'width:18%','placeholder'=>trans('all.author')]) !!}

            {!! Form::text('m_from',filter_request($request,'m_from'),['class'=>'controls form-control','style'=>'width:18%','id'=>'datetimepicker1','placeholder'=>trans('all.from')]) !!}

            {!! Form::text('m_to',filter_request($request,'m_to'),['class'=>'controls form-control','style'=>'width:18%','id'=>'datetimepicker2','placeholder'=>trans('all.to')]) !!}

            {!! Form::submit(trans('all.filter'),['class' => 'btn btn-primary btn-default']) !!}

            {!! Form::submit(trans('all.clean'),['class' => 'btn btn-danger btn-default','onClick' => '$("select[name=m_cat]").val("");$("input[name=m_to],input[name=m_from],input[name=m_author]").val("");']) !!}
            <div class="fix"></div>
        </div>

    {!! Form::close() !!}

</div>