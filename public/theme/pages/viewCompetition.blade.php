@extends('theme.app')

@section('content')
    <div class="read">
        <h3>{{$item->title}}</h3>
        <div class="read_content">
            @if(count($images) > 0)<div class="main-img"><img src="{!!  get_img_url($images[0]->img)!!}" class="img-responsive"/></div> @endif
            {!! do_shortcode($item->body) !!}
           <div class="fix"></div>
            <div class="competition-form">
               <form method="post" action="{{action('WelcomeController@sendComp')}}" onsubmit="return sendCompetitionData(this);return false;">
                   <input type="hidden" name="redirect_url" value="{{action('WelcomeController@showCat','kilpailut')}}">
                   <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                   <table width="96%">
                       @if(!empty($item->extra_fields))
                           {{--*/ $fields = unserialize($item->extra_fields); $i=0; /*--}}
                           @if(count($fields) > 0)
                               @foreach($fields['competition']['question'] as $com) {{--*/$i++/*--}}
                               <tr class="question">
                                   <input type="hidden" name="item" value="{{$item->id}}"/>
                                   <td colspan="2" class="question-title">{{$com['title']}}</td>
                               </tr>
                               {{--*/$a=0;/*--}}
                               @foreach($com['answer'] as $key=>$ans){{--*/$a++/*--}}
                               <tr>
                                   <td align="left" style="width:30px;" class="radio_input">
                                       <input type="radio" id="answer_{{$i}}_{{$a}}" name="question{{$i}}" value="{{$key}}"/>
                                       <label for="answer_{{$i}}_{{$a}}"></label>
                                   </td>
                                   <td align="left"><label for="answer_{{$i}}_{{$a}}">{{$ans}}</label></td>
                               </tr>
                               @endforeach
                               @endforeach
                           @endif
                       @endif
                   </table>
                   {{--<table width="96%">
                       <tr>
                           <td width="35%">
                               <table width="100%">
                                   <tr>
                                       <td>
                                           <label for="first_name">{{trans('all.first_name')}}</label>
                                           <input required="required" type="text" name="first_name" class="input"/>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td>
                                           <label for="last_name">{{trans('all.last_name')}}</label>
                                           <input required="required" type="text" name="last_name" class="input"/>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td>
                                           <label for="age">{{trans('all.age')}}</label>
                                           <input required="required" type="text" name="age" class="input"/>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td>
                                           <label for="address">{{trans('all.address')}}</label>
                                           <input required="required" type="text" name="address" class="input"/>
                                       </td>
                                   </tr>

                               </table>
                           </td>
                           <td width="16%"></td>
                           <td width="35%">
                               <table width="100%">
                                   <tr>
                                       <td>
                                           <label for="zip_code">{{trans('all.zip_code')}}</label>
                                           <input required="required" type="text" name="zip_code" class="input"/>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td>
                                           <label for="town">{{trans('all.town')}}</label>
                                           <input required="required" type="text" name="town" class="input"/>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td>
                                           <label for="phone">{{trans('all.phone')}}</label>
                                           <input required="required" type="text" name="phone" class="input"/>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td>
                                           <label for="email">{{trans('all.e_mail')}}</label>
                                           <input required="required" type="email" name="email" class="input"/>
                                       </td>
                                   </tr>
                               </table>
                           </td>
                       </tr>
                       <tr>
                           <td>
                               <input type="submit" name="send" value="{{trans('all.send')}}"/>
                           </td>
                       </tr>
                   </table>--}}
                   <div class="container-fluid no-padding">
                       <div class="row no-margin">
                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                               <label for="first_name">{{trans('all.first_name')}}</label>
                               <input required="required" type="text" name="first_name" class="input"/>
                           </div>
                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                               <label for="last_name">{{trans('all.last_name')}}</label>
                               <input required="required" type="text" name="last_name" class="input"/>
                           </div>
                       </div>
                       <div class="row no-margin">
                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                               <label for="age">{{trans('all.age')}}</label>
                               <input required="required" type="text" name="age" class="input"/>
                           </div>
                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                               <label for="address">{{trans('all.address')}}</label>
                               <input required="required" type="text" name="address" class="input"/>
                           </div>
                       </div>
                       <div class="row no-margin">
                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                               <label for="zip_code">{{trans('all.zip_code')}}</label>
                               <input required="required" type="text" name="zip_code" class="input"/>
                           </div>
                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                               <label for="town">{{trans('all.town')}}</label>
                               <input required="required" type="text" name="town" class="input"/>
                           </div>
                       </div>
                       <div class="row no-margin">
                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                               <label for="phone">{{trans('all.phone')}}</label>
                               <input required="required" type="text" name="phone" class="input"/>
                           </div>
                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                               <label for="email">{{trans('all.e_mail')}}</label>
                               <input required="required" type="email" name="email" class="input"/>
                           </div>
                       </div>
                       <div class="row no-margin" style="margin: 20px 0 0 15px !important">
                           <input type="submit" name="send" value="{{trans('all.send')}}"/>
                       </div>
                   </div>
               </form>
            </div>
        </div>
        <div class="fix"></div>
        <div class="share-buttons">
            <ul>
                <li><span>{{trans('all.share')}}</span></li>
                <li class="facebook-icon-o"><a href="http://www.facebook.com/sharer.php?u={{Request::url()}}" onClick="return shareWindow('Facebook',this)"></a></li>
                <li class="twitter-icon-o"><a href="https://twitter.com/intent/tweet?url={{Request::url()}}&amp;text={{$item->title}}&amp;via=radioclassic.fi" onClick="return shareWindow('Twitter',this)"></a></li>
                <li class="google-icon-o"><a href="https://plus.google.com/share?url={{Request::url()}}" onClick="return shareWindow('Google',this)"></a></li>
            </ul>
        </div>
        <div class="fix"></div>
    </div>
@stop