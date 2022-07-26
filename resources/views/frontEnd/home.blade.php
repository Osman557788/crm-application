@extends('frontEnd.layout')

@section('content')

    <!-- start Home Slider -->
    @include('frontEnd.includes.slider')
    <!-- end Home Slider -->

    @if(!empty($HomePage))
        @if(@$HomePage->{"details_" . @Helper::currentLanguage()->code} !="")
            <section class="content-row-no-bg home-welcome">
                <div class="container">
                    {!! @$HomePage->{"details_" . @Helper::currentLanguage()->code} !!}
                </div>
            </section>
        @endif
    @endif

    @if(count($TextBanners)>0)
        @foreach($TextBanners->slice(0,1) as $TextBanner)
            <?php
            try {
                $TextBanner_type = $TextBanner->webmasterBanner->type;
            } catch (Exception $e) {
                $TextBanner_type = 0;
            }
            ?>
        @endforeach
        <?php
        $title_var = "title_" . @Helper::currentLanguage()->code;
        $title_var2 = "title_" . env('DEFAULT_LANGUAGE');
        $details_var = "details_" . @Helper::currentLanguage()->code;
        $details_var2 = "details_" . env('DEFAULT_LANGUAGE');
        $file_var = "file_" . @Helper::currentLanguage()->code;
        $file_var2 = "file_" . env('DEFAULT_LANGUAGE');

        $col_width = 12;
        if (count($TextBanners) == 2) {
            $col_width = 6;
        }
        if (count($TextBanners) == 3) {
            $col_width = 4;
        }
        if (count($TextBanners) > 3) {
            $col_width = 3;
        }
        ?>
        <section class="content-row-no-bg p-b-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row" style="margin-bottom: 0;">
                            @foreach($TextBanners as $TextBanner)
                                <?php
                                if ($TextBanner->$title_var != "") {
                                    $BTitle = $TextBanner->$title_var;
                                } else {
                                    $BTitle = $TextBanner->$title_var2;
                                }
                                if ($TextBanner->$details_var != "") {
                                    $BDetails = $TextBanner->$details_var;
                                } else {
                                    $BDetails = $TextBanner->$details_var2;
                                }
                                if ($TextBanner->$file_var != "") {
                                    $BFile = $TextBanner->$file_var;
                                } else {
                                    $BFile = $TextBanner->$file_var2;
                                }
                                ?>
                                <div class="col-lg-{{$col_width}}">
                                    <div class="box">
                                        <div class="box-gray aligncenter">
                                            @if($TextBanner->code !="")
                                                {!! $TextBanner->code !!}
                                            @else
                                                @if($TextBanner->icon !="")
                                                    <div class="icon">
                                                        <i class="fa {{$TextBanner->icon}} fa-3x"></i>
                                                    </div>
                                                @elseif($BFile !="")
                                                    <img src="{{ URL::to('uploads/banners/'.$BFile) }}"
                                                         alt="{{ $BTitle }}"/>
                                                @endif
                                                <h4>{!! $BTitle !!}</h4>
                                                @if($BDetails !="")
                                                    <p>{!! nl2br($BDetails) !!}</p>
                                                @endif
                                            @endif

                                        </div>
                                        @if($TextBanner->link_url !="")
                                            <div class="box-bottom">
                                                <a href="{!! $TextBanner->link_url !!}">{{ __('frontend.moreDetails') }}</a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(count($HomeTopics)>0)
        <section class="content-row-bg">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="home-row-head">
                            <h2 class="heading">{{ __('frontend.homeContents1Title') }}</h2>
                            <small>{{ __('frontend.homeContents1desc') }}</small>
                        </div>
                        <div id="owl-slider" class="owl-carousel owl-theme listing">
                            <?php
                            $title_var = "title_" . @Helper::currentLanguage()->code;
                            $title_var2 = "title_" . env('DEFAULT_LANGUAGE');
                            $details_var = "details_" . @Helper::currentLanguage()->code;
                            $details_var2 = "details_" . env('DEFAULT_LANGUAGE');
                            $section_url = "";
                            ?>
                            @foreach($HomeTopics as $HomeTopic)
                                <?php
                                if ($HomeTopic->$title_var != "") {
                                    $title = $HomeTopic->$title_var;
                                } else {
                                    $title = $HomeTopic->$title_var2;
                                }
                                if ($HomeTopic->$details_var != "") {
                                    $details = $details_var;
                                } else {
                                    $details = $details_var2;
                                }
                                if ($section_url == "") {
                                    $section_url = Helper::sectionURL($HomeTopic->webmaster_id);
                                }
                                ?>
                                <div class="item">
                                    <h4>
                                        @if($HomeTopic->icon !="")
                                            <i class="fa {!! $HomeTopic->icon !!} "></i>&nbsp;
                                        @endif
                                        {{ $title }}
                                    </h4>
                                    @if($HomeTopic->photo_file !="")
                                        <img src="{{ URL::to('uploads/topics/'.$HomeTopic->photo_file) }}"
                                             alt="{{ $title }}"/>
                                    @endif

                                    {{--Additional Feilds--}}
                                    @if(count($HomeTopic->webmasterSection->customFields->where("in_listing",true)) >0)
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div>
                                                    <?php
                                                    $cf_title_var = "title_" . @Helper::currentLanguage()->code;
                                                    $cf_title_var2 = "title_" . env('DEFAULT_LANGUAGE');
                                                    ?>
                                                    @foreach($HomeTopic->webmasterSection->customFields->where("in_listing",true) as $customField)
                                                        <?php
                                                        // check permission
                                                        $view_permission_groups = [];
                                                        if ($customField->view_permission_groups != "") {
                                                            $view_permission_groups = explode(",", $customField->view_permission_groups);
                                                        }
                                                        if (in_array(0, $view_permission_groups) || $customField->view_permission_groups == "") {
                                                        // have permission & continue
                                                        ?>
                                                        @if ($customField->in_listing)
                                                            <?php
                                                            if ($customField->$cf_title_var != "") {
                                                                $cf_title = $customField->$cf_title_var;
                                                            } else {
                                                                $cf_title = $customField->$cf_title_var2;
                                                            }


                                                            $cf_saved_val = "";
                                                            $cf_saved_val_array = array();
                                                            if (count($HomeTopic->fields) > 0) {
                                                                foreach ($HomeTopic->fields as $t_field) {
                                                                    if ($t_field->field_id == $customField->id) {
                                                                        if ($customField->type == 7) {
                                                                            // if multi check
                                                                            $cf_saved_val_array = explode(", ", $t_field->field_value);
                                                                        } else {
                                                                            $cf_saved_val = $t_field->field_value;
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            ?>

                                                            @if(($cf_saved_val!="" || count($cf_saved_val_array) > 0) && ($customField->lang_code == "all" || $customField->lang_code == @Helper::currentLanguage()->code))
                                                                @if($customField->type ==12)
                                                                    {{--Vimeo Video Link--}}
                                                                @elseif($customField->type ==11)
                                                                    {{--Youtube Video Link--}}
                                                                @elseif($customField->type ==10)
                                                                    {{--Video File--}}
                                                                @elseif($customField->type ==9)
                                                                    {{--Attach File--}}
                                                                @elseif($customField->type ==8)
                                                                    {{--Photo File--}}
                                                                @elseif($customField->type ==7)
                                                                    {{--Multi Check--}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!!  $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            <?php
                                                                            $cf_details_var = "details_" . @Helper::currentLanguage()->code;
                                                                            $cf_details_var2 = "details_en" . env('DEFAULT_LANGUAGE');
                                                                            if ($customField->$cf_details_var != "") {
                                                                                $cf_details = $customField->$cf_details_var;
                                                                            } else {
                                                                                $cf_details = $customField->$cf_details_var2;
                                                                            }
                                                                            $cf_details_lines = preg_split('/\r\n|[\r\n]/', $cf_details);
                                                                            $line_num = 1;
                                                                            ?>
                                                                            @foreach ($cf_details_lines as $cf_details_line)
                                                                                @if (in_array($line_num,$cf_saved_val_array))
                                                                                    <span class="badge">
                                                            {!! $cf_details_line !!}
                                                        </span>
                                                                                @endif
                                                                                <?php
                                                                                $line_num++;
                                                                                ?>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type ==6)
                                                                    {{--Select--}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!!  $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            <?php
                                                                            $cf_details_var = "details_" . @Helper::currentLanguage()->code;
                                                                            $cf_details_var2 = "details_en" . env('DEFAULT_LANGUAGE');
                                                                            if ($customField->$cf_details_var != "") {
                                                                                $cf_details = $customField->$cf_details_var;
                                                                            } else {
                                                                                $cf_details = $customField->$cf_details_var2;
                                                                            }
                                                                            $cf_details_lines = preg_split('/\r\n|[\r\n]/', $cf_details);
                                                                            $line_num = 1;
                                                                            ?>
                                                                            @foreach ($cf_details_lines as $cf_details_line)
                                                                                @if ($line_num == $cf_saved_val)
                                                                                    {!! $cf_details_line !!}
                                                                                @endif
                                                                                <?php
                                                                                $line_num++;
                                                                                ?>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type ==5)
                                                                    {{--Date & Time--}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!!  $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            {!! date('Y-m-d H:i:s', strtotime($cf_saved_val)) !!}
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type ==4)
                                                                    {{--Date--}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!!  $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            {!! date('Y-m-d', strtotime($cf_saved_val)) !!}
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type ==3)
                                                                    {{--Email Address--}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!!  $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            {!! $cf_saved_val !!}
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type ==2)
                                                                    {{--Number--}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!!  $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            {!! $cf_saved_val !!}
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type ==1)
                                                                    {{--Text Area--}}
                                                                @else
                                                                    {{--Text Box--}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!!  $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            {!! $cf_saved_val !!}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif
                                                        <?php
                                                        }
                                                        ?>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    {{--End of -- Additional Feilds--}}
                                    <p class="text-justify">{!! mb_substr(strip_tags($HomeTopic->$details),0, 300)."..." !!}
                                        &nbsp; <a
                                            href="{{ Helper::topicURL($HomeTopic->id) }}">{{ __('frontend.readMore') }}
                                            <i
                                                class="fa fa-caret-{{ @Helper::currentLanguage()->right }}"></i></a>
                                    </p>

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="more-btn">
                            <a href="{{ url($section_url) }}" class="btn btn-theme"><i
                                    class="fa fa-angle-left"></i>&nbsp; {{ __('frontend.viewMore') }}
                                &nbsp;<i
                                    class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endif

    @if(count($HomePhotos)>0)
        <section class="content-row-no-bg">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="home-row-head">
                            <h2 class="heading">{{ __('frontend.homeContents2Title') }}</h2>
                            <small>{{ __('frontend.homeContents2desc') }}</small>
                        </div>
                        <div class="row">
                            <section id="projects">
                                <ul id="thumbs" class="portfolio">
                                    <?php
                                    $title_var = "title_" . @Helper::currentLanguage()->code;
                                    $title_var2 = "title_" . env('DEFAULT_LANGUAGE');
                                    $details_var = "details_" . @Helper::currentLanguage()->code;
                                    $details_var2 = "details_" . env('DEFAULT_LANGUAGE');
                                    $section_url = "";
                                    $ph_count = 0;
                                    ?>
                                    @foreach($HomePhotos as $HomePhoto)
                                        <?php
                                        if ($HomePhoto->$title_var != "") {
                                            $title = $HomePhoto->$title_var;
                                        } else {
                                            $title = $HomePhoto->$title_var2;
                                        }

                                        if ($section_url == "") {
                                            $section_url = Helper::sectionURL($HomePhoto->webmaster_id);
                                        }
                                        ?>
                                        @foreach($HomePhoto->photos as $photo)
                                            @if($ph_count<12)
                                                <li class="col-lg-2 design" data-id="id-0" data-type="web">
                                                    <div class="relative">
                                                        <div class="item-thumbs">
                                                            <a class="hover-wrap fancybox" data-fancybox-group="gallery"
                                                               title="{{ $title }}"
                                                               href="{{ URL::to('uploads/topics/'.$photo->file) }}">
                                                                <span class="overlay-img"></span>
                                                                <span class="overlay-img-thumb"><i
                                                                        class="fa fa-search-plus"></i></span>
                                                            </a>
                                                            <!-- Thumb Image and Description -->
                                                            <img src="{{ URL::to('uploads/topics/'.$photo->file) }}"
                                                                 alt="{{ $title }}">
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                            <?php
                                            $ph_count++;
                                            ?>
                                        @endforeach
                                    @endforeach

                                </ul>
                            </section>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="more-btn">
                                    <a href="{{ url($section_url) }}" class="btn btn-theme"><i
                                            class="fa fa-angle-left"></i>&nbsp; {{ __('frontend.viewMore') }}
                                        &nbsp;<i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(count($HomePartners)>0)
        <section class="content-row-no-bg top-line">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="home-row-head">
                            <h2 class="heading">{{ __('frontend.partners') }}</h2>
                            <small>{{ __('frontend.partnersMsg') }}</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="partners_carousel slide" id="myCarousel" style="direction: ltr">
                        <div class="carousel-inner">
                            <div class="item active">
                                <ul class="thumbnails">
                                    <?php
                                    $ii = 0;
                                    $title_var = "title_" . @Helper::currentLanguage()->code;
                                    $title_var2 = "title_" . env('DEFAULT_LANGUAGE');
                                    $details_var = "details_" . @Helper::currentLanguage()->code;
                                    $details_var2 = "details_" . env('DEFAULT_LANGUAGE');
                                    $section_url = "";
                                    ?>

                                    @foreach($HomePartners as $HomePartner)
                                        <?php
                                        if ($HomePartner->$title_var != "") {
                                            $title = $HomePartner->$title_var;
                                        } else {
                                            $title = $HomePartner->$title_var2;
                                        }

                                        if ($section_url == "") {
                                            $section_url = Helper::sectionURL($HomePartner->webmaster_id);
                                        }

                                        if ($ii == 6) {
                                            echo "
                                                    </ul>
                                </div><!-- /Slide -->
                                <div class='item'>
                                    <ul class='thumbnails'>
                                                    ";
                                            $ii = 0;
                                        }
                                        ?>
                                        <li class="col-sm-2">
                                            <div>
                                                <div class="thumbnail">
                                                    <img src="{{ URL::to('uploads/topics/'.$HomePartner->photo_file) }}"
                                                         data-placement="bottom" title="{{ $title }}"
                                                         alt="{{ $title }}">
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                        </li>
                                        <?php
                                        $ii++;
                                        ?>
                                    @endforeach

                                </ul>
                            </div><!-- /Slide -->
                        </div>
                        <nav>
                            <ul class="control-box pager">
                                <li><a data-slide="prev" href="#myCarousel" class=""><i
                                            class="fa fa-angle-left"></i></a></li>
                                {{--<li><a href="{{ url($section_url) }}">{{ __('frontend.viewMore') }}</a>--}}
                                {{--</li>--}}
                                <li><a data-slide="next" href="#myCarousel" class=""><i
                                            class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </nav>
                        <!-- /.control-box -->

                    </div><!-- /#myCarousel -->
                </div>

            </div>

        </section>
    @endif

@endsection
