@extends('/layouts/master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">
@stop

@section('title')
    <title>Plans</title>
@stop
@section('body')
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row"></div>
    <section id="basic-tabs-components">
        <div class="row match-height">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach($company as $c)
                                <li class="nav-item">
                                    <a class="nav-link @if($loop->iteration == 1) active @endif" id="{{str_replace(' ', '-', $c->title)}}-tab" data-toggle="tab" href="#{{str_replace(' ', '-', $c->title)}}" aria-controls="{{str_replace(' ', '-', $c->title)}}" role="tab" aria-selected="true">{{ucwords($c->title)}}</a>
                                </li>
                            @endforeach
                        </ul>
                        
                        <div class="tab-content">
                            @foreach($company as $c)
                                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{str_replace(' ', '-', $c->title)}}" aria-labelledby="{{str_replace(' ', '-', $c->title)}}-tab" role="tabpanel">
                                    <div class="row">
                                        @foreach($c->plan_type_detail as $plan)
                                            <div class="col-md-12 col-sm-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">{{ucwords($plan->title)}}</h4>
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <li>
                                                                    <a data-action="collapse"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    @foreach($plan->plan_details as $details)
                                                        <div class="card-content collapse show">
                                                            <div class="card-body">
                                                                <p class="card-text">
                                                                    {{ucwords($plan->title)}}
                                                                </p>
                                                                <p class="card-text">
                                                                    {{$plan->description}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Basic Tabs ends -->
        </div>
    </section>
</div>
@endsection

@section('javascript')

@stop