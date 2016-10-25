<table width="100%">
    <thead>
    <tr>
        <td><a onClick="addQuestion()" class="btn btn-success"><i class="fa fa-plus"></i> {{trans('all.add_question')}}</a></td>
    </tr>
    </thead>
    <tbody>

    @if(count(validate_extra_field($extra_fields,'competition')) > 0)
      @if(count(validate_extra_field($extra_fields['competition'],'question')) > 1)
          {{--*/ $i = 1; /*--}}
          @foreach($extra_fields['competition']['question'] as $comp)
              @if($i > 0)
          <tr>
              <td>{!! Form::text('extra_fields[competition][question]['.$i.'][title]',$comp['title'],['class'=>'form-control','placeholder'=>trans('all.question').' '.$i]) !!}</td>
          </tr>
          <tr>
              <td>
                  <table width="100%">
                      <thead>
                      <tr>
                          <th>{{trans('all.true_answer')}}</th><th>{{trans('all.answer')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td>{!! Form::radio('extra_fields[competition][question]['.$i.'][true_answer]',1,(isset($comp['true_answer']) && $comp['true_answer'] == 1) ? 'checked' : null) !!}</td>
                          <td>{!! Form::text('extra_fields[competition][question]['.$i.'][answer][1]',$comp['answer'][1],['class'=>'form-control','placeholder'=>trans('all.answer').' 1']) !!}</td>
                      </tr>
                      <tr>
                          <td>{!! Form::radio('extra_fields[competition][question]['.$i.'][true_answer]',2,(isset($comp['true_answer']) && $comp['true_answer'] == 2) ? 'checked' : null) !!}</td>
                          <td>{!! Form::text('extra_fields[competition][question]['.$i.'][answer][2]',$comp['answer'][2],['class'=>'form-control','placeholder'=>trans('all.answer').' 2']) !!}</td>
                      </tr>
                      <tr>
                          <td>{!! Form::radio('extra_fields[competition][question]['.$i.'][true_answer]',3,(isset($comp['true_answer']) && $comp['true_answer'] == 3) ? 'checked' : null) !!}</td>
                          <td>{!! Form::text('extra_fields[competition][question]['.$i.'][answer][3]',$comp['answer'][3],['class'=>'form-control','placeholder'=>trans('all.answer').' 3']) !!}</td>
                      </tr>
                      </tbody>
                  </table>
              </td>
          </tr>
          @endif
          {{--*/ $i++ /*--}}
          @endforeach
      @endif
        @else
        <tr>
            <td>{!! Form::text('extra_fields[competition][question][1][title]',null,['class'=>'form-control','placeholder'=>trans('all.question').' 1']) !!}</td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <thead>
                    <tr>
                        <th>{{trans('all.true_answer')}}</th><th>{{trans('all.answer')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::radio('extra_fields[competition][question][1][true_answer]',1,null) !!}</td>
                        <td>{!! Form::text('extra_fields[competition][question][1][answer][1]',null,['class'=>'form-control','placeholder'=>trans('all.answer').' 1']) !!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::radio('extra_fields[competition][question][1][true_answer]',2,null) !!}</td>
                        <td>{!! Form::text('extra_fields[competition][question][1][answer][2]',null,['class'=>'form-control','placeholder'=>trans('all.answer').' 2']) !!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::radio('extra_fields[competition][question][1][true_answer]',3,null) !!}</td>
                        <td>{!! Form::text('extra_fields[competition][question][1][answer][3]',null,['class'=>'form-control','placeholder'=>trans('all.answer').' 3']) !!}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    @endif
    </tbody>
    <tfoot style="display:none">
    <tr>
        <td align="right">
            <a onClick="removeQuestion()" class="btn btn-danger"><i class="fa fa-minus"></i> {{trans('all.remove_last')}}</a>
        </td>
    </tr>
    </tfoot>
</table>