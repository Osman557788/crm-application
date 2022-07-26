@if(Helper::GeneralSiteSettings("style_subscribe"))
    <div class="col-lg-{{$bx4w}}">
        <div class="widget">
            <h4 class="widgetheading"><i class="fa fa-envelope-open"></i>&nbsp; {{ __('frontend.newsletter') }}</h4>
            <p>{{ __('frontend.subscribeToOurNewsletter') }}</p>
            <div id="subscribesendmessage"><i class="fa fa-check-circle"></i> &nbsp;{{ __('frontend.subscribeToOurNewsletterDone') }}</div>
            <div id="subscribeerrormessage">{{ __('frontend.youMessageNotSent') }}</div>

            {{Form::open(['route'=>['Home'],'method'=>'POST','class'=>'subscribeForm'])}}
            <div class="form-group">
                {!! Form::text('subscribe_name',"", array('placeholder' => __('frontend.yourName'),'class' => 'form-control','id'=>'subscribe_name', 'data-msg'=> __('frontend.enterYourName'),'data-rule'=>'minlen:4')) !!}
                <div class="alert alert-warning validation"></div>
            </div>
            <div class="form-group">
                {!! Form::email('subscribe_email',"", array('placeholder' => __('frontend.yourEmail'),'class' => 'form-control','id'=>'subscribe_email', 'data-msg'=> __('frontend.enterYourEmail'),'data-rule'=>'email')) !!}
                <div class="validation"></div>
            </div>
            <button type="submit" class="btn btn-info">{{ __('frontend.subscribe') }}</button>
            {{Form::close()}}
        </div>
    </div>
@endif
