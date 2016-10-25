@extends('admin.app')

@section('content')
<div class="container-fluid" @if(Auth::guest())style="margin-top:10%;"@endif>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('all.admin_panel')}}</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>{{trans('all.error')}}!</strong>{{trans('all.error_input')}}.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

                        <div class="form-group">
                            <label class="col-md-4 control-label"></label>
                            <div class="col-md-6">
                                {!! Form::open(['method'=>'post','action'=>'LanguageController@cookie','name'=>'language']) !!}
                                {!! Form::select('locale',get_languages(),App::getLocale()
                                ,['onchange'=>'document.language.submit()','class'=>'form-control','style'=>'margin-left:-5px']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
					<form class="form-horizontal" role="form" method="POST" action="{{ action('Auth\AuthController@postLogin') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">{{trans('all.email')}}</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">{{trans('all.password')}}</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> {{trans('all.remember')}}
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">{{trans('all.login')}}</button>

								<!--<a class="btn btn-link" href="{{url('/password/email') }}">Forgot Your Password?</a>-->
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
