@if (Auth::guest() ||  Auth::user()->hasRole('User'))

@else
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand navbar-pos-center" href="javascript:void(0)" target="_blank"><img src="{{ url('/') }}/uploads/img/logo.png" height="20"></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}" target="_blank">{{trans('all.visit_website')}}</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/is-admin/home') }}">{{trans('all.administration')}}</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        {!! Form::open(['method'=>'post','action'=>'LanguageController@cookie','name'=>'languages']) !!}
                        {!! Form::select('locale', get_languages(),App::getLocale(),['onchange'=>'document.languages.submit()','class'=>'form-control']) !!}
                        {!! Form::close() !!}
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ action('Auth\AuthController@getLogout') }}">{{trans('all.logout')}}</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
@endif