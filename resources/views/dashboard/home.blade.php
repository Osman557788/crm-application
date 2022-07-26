@extends('dashboard.layouts.master')
@section('title', Helper::GeneralSiteSettings("site_title_".@Helper::currentLanguage()->code))
@push("after-styles")
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/flags.css') }}" type="text/css"/>
@endpush
@section('content')
    <div class="padding p-b-0">
        <div class="margin">
            <h5 class="m-b-0 _300">{{ __('backend.hi') }} <span
                    class="text-primary">{{ Auth::user()->name }}</span>, {{ __('backend.welcomeBack') }}
            </h5>
        </div>
        @if(@Auth::user()->permissionsGroup->home_status)
            @if(strip_tags(@Auth::user()->permissionsGroup->{'home_details_'. @Helper::currentLanguage()->code}) !="")
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box p-a">
                            {!! @Auth::user()->permissionsGroup->{'home_details_'. @Helper::currentLanguage()->code} !!}
                        </div>
                    </div>
                </div>
            @endif
            @if(@Auth::user()->permissionsGroup->home_links !="")
                <?php
                try {
                $home_links = json_decode(@Auth::user()->permissionsGroup->home_links);
                } catch (\Exception $e) {
                $home_links = [];
                }
                ?>
                <div class="row">
                    @if(count($home_links) >0)
                        @foreach($home_links as $key=>$home_link)
                            <div class="col-sm-4 col-md-4 col-lg-3">
                                <a href="{{ @$home_link->btn_link }}"
                                   {{ (@$home_link->btn_target)?"target=\"_blank\"":"" }}
                                   class="m-b w-100 {!! @$home_link->btn_class !!}">{!! @$home_link->{'btn_title_'. @Helper::currentLanguage()->code} !!}</a>
                            </div>
                        @endforeach
                    @endif
                </div>
                @endif
            @else
                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-4">
                        <div class="row">
                        <?php
                        $data_sections_arr = explode(",", Auth::user()->permissionsGroup->data_sections);
                        $clr_ary = array("info", "danger", "success", "accent",);
                        $ik = 0;
                        $mnu_title_var = "title_" . @Helper::currentLanguage()->code;
                        $mnu_title_var2 = "title_" . env('DEFAULT_LANGUAGE');
                        ?>
                            @foreach($GeneralWebmasterSections as $headerWebmasterSection)
                                @if(in_array($headerWebmasterSection->id,$data_sections_arr))
                                    @if($ik<4)
                                        <?php
                                        if ($headerWebmasterSection->$mnu_title_var != "") {
                                            $GeneralWebmasterSectionTitle = $headerWebmasterSection->$mnu_title_var;
                                        } else {
                                            $GeneralWebmasterSectionTitle = $headerWebmasterSection->$mnu_title_var2;
                                        }
                                        $LiIcon = "&#xe2c8;";
                                        if ($headerWebmasterSection->type == 3) {
                                            $LiIcon = "&#xe050;";
                                        }
                                        if ($headerWebmasterSection->type == 2) {
                                            $LiIcon = "&#xe63a;";
                                        }
                                        if ($headerWebmasterSection->type == 1) {
                                            $LiIcon = "&#xe251;";
                                        }
                                        if ($headerWebmasterSection->type == 0) {
                                            $LiIcon = "&#xe2c8;";
                                        }
                                        if ($headerWebmasterSection->id == 1) {
                                            $LiIcon = "&#xe3e8;";
                                        }
                                        if ($headerWebmasterSection->id == 7) {
                                            $LiIcon = "&#xe02f;";
                                        }
                                        if ($headerWebmasterSection->id == 2) {
                                            $LiIcon = "&#xe540;";
                                        }
                                        if ($headerWebmasterSection->id == 3) {
                                            $LiIcon = "&#xe307;";
                                        }
                                        if ($headerWebmasterSection->id == 8) {
                                            $LiIcon = "&#xe8f6;";
                                        }

                                        ?>
                                        <div class="col-xs-6">
                                            <div class="box p-a" style="cursor: pointer"
                                                 onclick="location.href='{{ route('topics',$headerWebmasterSection->id) }}'">
                                                <a href="{{ route('topics',$headerWebmasterSection->id) }}">
                                                    <div class="pull-left m-r">
                                                        <i class="material-icons  text-2x text-{{$clr_ary[$ik]}} m-y-sm">{!! $LiIcon !!}</i>
                                                    </div>
                                                    <div class="clear">
                                                        <div
                                                            class="text-muted">{{ $GeneralWebmasterSectionTitle }}</div>
                                                        <h4 class="m-a-0 text-md _600">{{ $headerWebmasterSection->topics->count() }}</h4>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                        $ik++
                                        ?>
                                    @endif
                                @endif
                            @endforeach
                            <div class="col-xs-12">
                                <div class="row-col box-color text-center primary">
                                    <div class="row-cell p-a">
                                        {{ __('backend.visitors') }}
                                        <h4 class="m-a-0 text-md _600"><a href>{{$TodayVisitors}}</a></h4>
                                    </div>
                                    <div class="row-cell p-a dker">
                                        {{ __('backend.pageViews') }}
                                        <h4 class="m-a-0 text-md _600"><a href>{{$TodayPages}}</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 col-lg-8">
                        <div class="row-col box bg">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3>{{ __('backend.visitors') }}</h3>
                                    <small>{{ __('backend.lastFor7Days') }}</small>
                                </div>
                                <div class="box-body">
                                    <div ui-jp="plot" ui-refresh="app.setting.color" ui-options="
			              [
			                {
			                  data: [
                  <?php
                                    $ii = 1;
                                    ?>
                                    @foreach($Last7DaysVisitors as $id)

                                    @if($ii<=10)
                                    @if($ii!=1)
                                        ,
@endif
                                    <?php
                                    $i2 = 0;
                                    ?>
                                    @foreach($id as $key => $val)
                                    <?php
                                    if ($i2 == 1) {
                                    ?>
                                        [{{ $ii }}, {{$val}}]
                                <?php
                                    }
                                    $i2++;
                                    ?>
                                    @endforeach
                                    @endif
                                    <?php $ii++;?>
                                    @endforeach
                                        ],
                                      points: { show: true, radius: 0},
                                      splines: { show: true, tension: 0.45, lineWidth: 2, fill: 0 }
                                    },
                                    {
                                      data: [
<?php
                                    $ii = 1;
                                    ?>
                                    @foreach($Last7DaysVisitors as $id)

                                    @if($ii<=10)
                                    @if($ii!=1)
                                        ,
@endif
                                    <?php
                                    $i2 = 0;
                                    ?>
                                    @foreach($id as $key => $val)
                                    <?php
                                    if ($i2 == 2) {
                                    ?>
                                        [{{ $ii }}, {{$val}}]
                                <?php
                                    }
                                    $i2++;
                                    ?>
                                    @endforeach
                                    @endif
                                    <?php $ii++;?>
                                    @endforeach
                                        ],
          points: { show: true, radius: 0},
          splines: { show: true, tension: 0.45, lineWidth: 2, fill: 0 }
        }
        ],
        {
        colors: ['#0cc2aa','#fcc100'],
        series: { shadowSize: 3 },
        xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
        yaxis:{ show: true, font: { color: '#ccc' }},
        grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' },
        tooltip: true,
        tooltipOpts: { content: '%x.0 is %y.4',  defaultTheme: false, shifts: { x: 0, y: -40 } }
        }
" style="height:162px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 dker">
                                <div class="box-header">
                                    <h3>{{ __('backend.reports') }}</h3>
                                </div>
                                <div class="box-body">
                                    <p class="text-muted">
                                        {{ __('backend.reportsDetails') }} : <br>
                                        <a href="{{ route('analytics', 'date') }}">{{ __('backend.visitorsAnalyticsBydate') }}</a>,
                                        <a href="{{ route('analytics', 'country') }}">{{ __('backend.visitorsAnalyticsByCountry') }}</a>,
                                        <a href="{{ route('analytics', 'city') }}">{{ __('backend.visitorsAnalyticsByCity') }}</a>,
                                        <a href="{{ route('analytics', 'os') }}">{{ __('backend.visitorsAnalyticsByOperatingSystem') }}</a>,
                                        <a href="{{ route('analytics', 'browser') }}">{{ __('backend.visitorsAnalyticsByBrowser') }}</a>,
                                        <a href="{{ route('analytics', 'referrer') }}">{{ __('backend.visitorsAnalyticsByReachWay') }}</a>,
                                        <a href="{{ route('analytics', 'hostname') }}">{{ __('backend.visitorsAnalyticsByHostName') }}</a>,
                                        <a href="{{ route('analytics', 'org') }}">{{ __('backend.visitorsAnalyticsByOrganization') }}</a>
                                    </p>
                                    <a href="{{ route('analytics', 'date') }}" style="margin-bottom: 5px;"
                                       class="btn btn-sm btn-outline rounded b-success">{{ __('backend.viewMore') }}</a><br>
                                    <a href="{{ route('visitors') }}"
                                       class="btn btn-sm btn-outline rounded b-info">{{ __('backend.visitorsAnalyticsVisitorsHistory') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xl-4">
                        <div class="box">
                            <div class="box-header b-b">
                                <h3>{{ __('backend.visitorsRate') }}</h3>
                                <small>{{ __('backend.visitorsRateToday')." [ ".Helper::formatDate(date('Y-m-d'))." ]" }}</small>
                            </div>
                            <div class="box-body">

                                <div ui-jp="plot" ui-options="
              [
                {
                  data: [{!! $TodayVisitorsRate !!}],
                  points: { show: true, radius: 5},
                  splines: { show: true, tension: 0.45, lineWidth: 0, fill: 0.4}
                }
              ],
              {
                colors: ['#0cc2aa'],
                series: { shadowSize: 3 },
                xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
                yaxis:{ show: true, font: { color: '#ccc' }, min:1},
                grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' },
                tooltip: true,
                tooltipOpts: { content: '%x.0 is %y.4',  defaultTheme: false, shifts: { x: 0, y: -40 } }
              }
            " style="height:200px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-4">
                        <div class="box" style="min-height: 300px">
                            <div class="box-header">
                                <h3>{{ __('backend.browsers') }}</h3>
                                <small>{{ __('backend.browsersCalculated') }}</small>
                            </div>

                            @if($TodayByBrowser1_val >0)
                                <div class="text-center b-t">
                                    <div class="row-col">
                                        <div class="row-cell p-a">
                                            <div class="inline m-b">
                                                <div ui-jp="easyPieChart" class="easyPieChart"
                                                     ui-refresh="app.setting.color"
                                                     data-redraw='true' data-percent="55" ui-options="{
	                      lineWidth: 8,
	                      trackColor: 'rgba(0,0,0,0.05)',
	                      barColor: '#0cc2aa',
	                      scaleColor: 'transparent',
	                      size: 100,
	                      scaleLength: 0,
	                      animate:{
	                        duration: 3000,
	                        enabled:true
	                      }
	                    }">
                                                    <div>
                                                        <h5>
                                                            <?php
                                                            echo $perc1 = round(($TodayByBrowser1_val * 100) / ($TodayByBrowser1_val + $TodayByBrowser2_val)) . "%";
                                                            ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                {{$TodayByBrowser1}}
                                                <small class="block m-b">{{$TodayByBrowser1_val}}</small>
                                                <a href="{{ route('analytics', 'browser') }}"
                                                   class="btn btn-sm white text-u-c rounded">{{ __('backend.more') }}</a>
                                            </div>
                                        </div>
                                        <div class="row-cell p-a dker">
                                            <div class="inline m-b">
                                                <div ui-jp="easyPieChart" class="easyPieChart"
                                                     ui-refresh="app.setting.color"
                                                     data-redraw='true' data-percent="45" ui-options="{
	                      lineWidth: 8,
	                      trackColor: 'rgba(0,0,0,0.05)',
	                      barColor: '#fcc100',
	                      scaleColor: 'transparent',
	                      size: 100,
	                      scaleLength: 0,
	                      animate:{
	                        duration: 3000,
	                        enabled:true
	                      }
	                    }">
                                                    <div>
                                                        <h5>
                                                            <?php
                                                            echo $perc1 = round(($TodayByBrowser2_val * 100) / ($TodayByBrowser1_val + $TodayByBrowser2_val)) . "%";
                                                            ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                {{$TodayByBrowser2}}
                                                <small class="block m-b">{{$TodayByBrowser2_val}}</small>
                                                <a href="{{ route('analytics', 'browser') }}"
                                                   class="btn btn-sm white text-u-c rounded">{{ __('backend.more') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-4">
                        <div class="box light lt" style="min-height: 300px">
                            <div class="box-header">
                                <h3> {{ __('backend.todayByCountry') }}</h3>
                            </div>
                            <div class="box-tool">
                                <ul class="nav">
                                    <li class="nav-item inline">
                                        <a href="{{ route('analytics', 'country') }}"
                                           class="btn btn-sm white text-u-c rounded">{{ __('backend.more') }}</a>
                                    </li>
                                </ul>
                            </div>
                            @if(count($TodayByCountry) == 0)
                                <div class="text-center m-t-1" style="color:#bbb">
                                    <h1><i class="material-icons">&#xe1b7;</i></h1>
                                    {{ __('backend.noData') }}</div>
                            @else
                                <ul class="list no-border p-b">
                                    <?php
                                    $ii = 1;
                                    ?>
                                    @foreach($TodayByCountry as $id)
                                        @if($ii<=4)
                                            <li class="list-item">
                                                <?php
                                                $i2 = 0;
                                                $v0 = "";
                                                $v1 = "";
                                                $v2 = 0;
                                                $v3 = 0;
                                                ?>
                                                @foreach($id as $key => $val)
                                                    @if($i2 == 0)
                                                        <?php $v0 = $val; ?>
                                                    @endif
                                                    @if($i2 == 1)
                                                        <?php $v1 = $val; ?>
                                                    @endif
                                                    @if($i2 == 2)
                                                        <?php $v2 = $val; ?>
                                                    @endif
                                                    @if($i2 == 3)
                                                        <?php $v3 = $val; ?>
                                                    @endif
                                                    <?php
                                                    $i2++;
                                                    ?>
                                                @endforeach

                                                <?php
                                                $flag = "";
                                                $country_code = strtolower($v1);
                                                if ($country_code != "unknown") {
                                                    $flag = "<div class='flag flag-$country_code' style='display: inline-block'></div> ";
                                                }
                                                ?>

                                                <a herf class="list-left">
	                  <span class="w-40 rounded dker">
		                  <span>{{$v1}}</span>
		              </span>
                                                </a>
                                                <div class="list-body">
                                                    <div>{!! $flag !!} {{$v0}}</div>
                                                    <small class="text-muted text-ellipsis">
                                                        {{ __('backend.visitors') }} : {{ $v2 }},
                                                        {{ __('backend.pageViews') }} : {{ $v3 }}
                                                    </small>
                                                </div>


                                            </li>
                                        @endif
                                        <?php $ii++;?>
                                    @endforeach

                                </ul>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="row">
                    <?php
                    $col_count = 0;
                    if (Helper::GeneralWebmasterSettings("inbox_status")) {
                        if (Auth::user()->permissionsGroup->inbox_status) {
                            $col_count++;
                        }
                    }
                    if (Helper::GeneralWebmasterSettings("calendar_status")) {
                        if (Auth::user()->permissionsGroup->calendar_status) {
                            $col_count++;
                        }
                    }
                    if (Helper::GeneralWebmasterSettings("newsletter_status")) {
                        if (Auth::user()->permissionsGroup->newsletter_status) {
                            $col_count++;
                        }
                    }
                    $col_width = 12;
                    if ($col_count > 0) {
                        $col_width = 12 / $col_count;
                    }
                    ?>

                    @if(Helper::GeneralWebmasterSettings("inbox_status"))
                        @if(@Auth::user()->permissionsGroup->inbox_status)
                            <div class="col-md-12 col-xl-{{$col_width}}">
                                <div class="box m-b-0" style="min-height: 370px">
                                    <div class="box-header">
                                        <h3>{{ __('backend.latestMessages') }}</h3>
                                    </div>
                                    <div class="box-tool">
                                        <ul class="nav">
                                            <li class="nav-item inline dropdown">
                                                <a class="nav-link text-muted p-x-xs" data-toggle="dropdown">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-scale pull-right">
                                                    <a class="dropdown-item"
                                                       href="{{ route("webmails") }}"> {!! __('backend.inbox') !!} </a>
                                                    <a class="dropdown-item"
                                                       href="{{ route("webmails",["group_id"=>"sent"]) }}">{!! __('backend.sent') !!}</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    @if(count($Webmails) == 0)
                                        <div class="text-center m-t-1" style="color:#bbb">
                                            <h1><i class="material-icons">&#xe156;</i></h1>
                                            {{ __('backend.noData') }}</div>
                                    @else
                                        <ul class="list-group no-border">
                                            @foreach($Webmails as $Webmail)
                                                <?php
                                                $s4ds_current_date = date('Y-m-d', $_SERVER['REQUEST_TIME']);
                                                $day_mm = date('Y-m-d', strtotime($Webmail->date));
                                                if ($day_mm == $s4ds_current_date) {
                                                    $dtformated = date('h:i A', strtotime($Webmail->date));
                                                } else {
                                                    $dtformated = Helper::formatDate($Webmail->date);
                                                }

                                                try {
                                                    $groupColor = $Webmail->webmailsGroup->color;
                                                    $groupName = $Webmail->webmailsGroup->name;
                                                } catch (Exception $e) {
                                                    $groupColor = "";
                                                    $groupName = "";
                                                }

                                                $fontStyle = "";
                                                $unreadIcon = "&#xe151;";
                                                $unreadbg = "";
                                                $unreadText = "";
                                                if ($Webmail->status == 0) {
                                                    $fontStyle = "_700";
                                                    $unreadIcon = "&#xe0be;";
                                                    $unreadbg = "style=\"background: $groupColor \"";
                                                    $unreadText = "style=\"color: $groupColor \"";
                                                }
                                                ?>
                                                <li class="list-group-item">
                                                    <div class="pull-right">
                                                        <small>{{ $dtformated }}</small>
                                                    </div>
                                                    <a href="{{ route("webmailsEdit",["id"=>$Webmail->id]) }}"
                                                       class="pull-left w-40 m-r">
                                    <span class="w-40 rounded danger" style="background: {!! $groupColor !!}">
		                  <i class="material-icons">{!! $unreadIcon !!}</i>
		                </span>
                                                    </a>
                                                    <div class="clear">
                                                        <a href="{{ route("webmailsEdit",["id"=>$Webmail->id]) }}"
                                                           class="_500 block">{{ $Webmail->from_name }}</a>
                                                        <span class="text-muted">{{ $Webmail->title }}</span>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>

                                        <div class="box-footer">
                                            <a href="{{ route("webmails",["group_id"=>"create"]) }}"
                                               class="btn btn-sm btn-outline b-primary rounded text-u-c pull-right">{{ __('backend.compose') }}</a>
                                            <a href="{{ route("webmails") }}"
                                               class="btn btn-sm white text-u-c rounded">{{ __('backend.more') }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                    @if(Helper::GeneralWebmasterSettings("calendar_status"))
                        @if(@Auth::user()->permissionsGroup->calendar_status)
                            <div class="col-md-12 col-xl-{{$col_width}}">
                                <div class="box m-b-0" style="min-height: 370px">
                                    <div class="box-header">
                                        <h3>{{ __('backend.notesEvents') }}</h3>
                                    </div>
                                    <div class="box-tool">
                                        <ul class="nav">
                                            <li class="nav-item inline">
                                                <a href="{{ route("calendarCreate") }}"
                                                   class="btn btn-sm white text-u-c rounded">{{ __('backend.addNew') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="box-body">
                                        @if(count($Events) == 0)
                                            <div class="text-center m-t-1" style="color:#bbb">
                                                <h1><i class="material-icons">&#xe5c3;</i></h1>
                                                {{ __('backend.noData') }}</div>
                                        @else
                                            <div class="streamline b-l m-l">
                                                @foreach($Events as $Event)
                                                <?php
                                                if ($Event->type == 3) {
                                                    $cls = "info";
                                                } elseif ($Event->type == 2) {
                                                    $cls = "danger";
                                                } elseif ($Event->type == 1) {
                                                    $cls = "success";
                                                } else {
                                                    $cls = "black";
                                                }
                                                ?>
                                                    <div class="sl-item  b-{{$cls}}">
                                                        <div class="sl-content">
                                                            <div class="sl-date text-muted">
                                                                @if($Event->type ==1 || $Event->type ==2)
                                                                    {{ Helper::formatDate($Event->start_date)." ".date("h:i A", strtotime($Event->start_date)) }}
                                                                @else
                                                                    {{ Helper::formatDate($Event->start_date) }}
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <a href="{{ route("calendarEdit",["id"=>$Event->id]) }}">{{ $Event->title }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if(Helper::GeneralWebmasterSettings("newsletter_status"))
                        @if(@Auth::user()->permissionsGroup->newsletter_status)
                            <div class="col-md-12 col-xl-{{$col_width}}">
                                <div class="box m-b-0" style="min-height: 370px">
                                    <div class="box-header">
                                        <h3>{{ __('backend.latestContacts') }}</h3>
                                    </div>
                                    <div class="box-tool">
                                        <ul class="nav">
                                            <li class="nav-item inline">
                                                <a href="{{ route("contacts") }}"
                                                   class="btn btn-sm white text-u-c rounded">{{ __('backend.addNew') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    @if(count($Contacts) == 0)
                                        <div class="text-center m-t-1" style="color:#bbb">
                                            <h1><i class="material-icons">&#xe7ef;</i></h1>
                                            {{ __('backend.noData') }}</div>
                                    @else
                                        <ul class="list no-border p-b">
                                            @foreach($Contacts as $Contact)
                                                <li class="list-item">
                                                    <a href="{{ route("contactsEdit",["id"=>$Contact->id]) }}"
                                                       class="list-left">
	                	<span class="w-40 avatar">
                            @if($Contact->photo!="")
                                <img src="{{ asset('uploads/contacts/'.$Contact->photo) }}"
                                     alt="{{ $Contact->first_name }} {{ $Contact->last_name }}">
                            @else
                                <img src="{{ asset('uploads/contacts/profile.jpg') }}"
                                     alt="{{ $Contact->first_name }} {{ $Contact->last_name }}" style="opacity: 0.5">
                            @endif
	                    </span>
                                                    </a>
                                                    <div class="list-body">
                                                        <div>
                                                            <a href="{{ route("contactsEdit",["id"=>$Contact->id]) }}">{{ $Contact->first_name }} {{ $Contact->last_name }}</a>
                                                        </div>
                                                        <small class="text-muted text-ellipsis"><span
                                                                dir="ltr">{{ $Contact->phone }}</span></small>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            @endif
    </div>
@endsection
