
<div class="row">
    <div class="col-sm-16">
        <div class="form-group">
            {!! Form::label('short_desc',trans('all.buying') .' '. trans('all.short_desc') . ' ('.trans('all.max').' 30 '.trans('all.symbol').') ') !!}
            {!! Form::input('text','short_desc',null,['class'=>'form-control','maxlength'=>30]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-16">
        <div class="form-group">
            {!! Form::label('long_desc',trans('all.buying') .' '. trans('all.description') . ' ('.trans('all.max').' 125 '.trans('all.symbol').') ') !!}
            {!! Form::textarea('long_desc',null,['class'=>'form-control','maxlength'=>125]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-16">
        <div class="form-group">
            {!! Form::label('url',trans('all.payment_url')) !!}
            {!! Form::text('url',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-16">
        <div class="form-group">
            {!! Form::label('back_url_s',trans('all.back_url_s')) !!}
            {!! Form::text('back_url_s',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-16">
        <div class="form-group">
            {!! Form::label('back_url_f',trans('all.back_url_f')) !!}
            {!! Form::text('back_url_f',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-16">
        <div class="form-group">
            {!! Form::label('merchant_trx',trans('all.transaction_id') . ' (merchant-trx)') !!}
            {!! Form::input('text','merchant_trx',null,['class'=>'form-control','maxlength'=>55]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-16">
        <div class="form-group">
            {!! Form::label('merchant_id',trans('all.merchant_id') . ' (merchantID)') !!}
            {!! Form::input('text','merchant_id',null,['class'=>'form-control','maxlength'=>55]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-16">
        <div class="form-group">
            {!! Form::label('account_id',trans('all.account_id') . ' (accountID)') !!}
            {!! Form::input('text','account_id',null,['class'=>'form-control','maxlength'=>55]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-16">
        <div class="form-group">
            {!! Form::label('page_id',trans('all.page_id') . ' (pageID)') !!}
            {!! Form::input('text','page_id',null,['class'=>'form-control','maxlength'=>55]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('currency',trans('all.currency_code')) !!}
            {!! Form::input('text','currency',null,['class'=>'form-control','maxlength'=>9]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('exponent',trans('all.currency_exponent')) !!}
            {!! Form::input('text','exponent',null,['class'=>'form-control','maxlength'=>9]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-24">
        <div class="form-group">
            {!! Form::submit($submitButtonText,['class' => 'btn btn-primary']) !!}
        </div>
    </div>
</div>
