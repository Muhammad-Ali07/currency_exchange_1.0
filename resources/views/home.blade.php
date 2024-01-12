@extends('layouts.home')

@section('content')
    @permission($data['permission'])
    <div class="home">
        <div class="row justify-content-center">
            {{-- <div class="col-md-3">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="users" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">92.6k</h2>
                        <p class="card-text">Subscribers Gained</p>
                    </div>
                    <div id="gained-chart"></div>
                </div>
            </div> --}}
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather='dollar-sign'></i>
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">{{ $data['today_sale'] . 'K' }}</h2>
                        <p class="card-text">Today Sale</p>
                    </div>
                    <div id="today_sale">
                        <div id="apexchartswypxcvwr" class="apexcharts-canvas apexchartswypxcvwr light" style="width: 237px; height: 100px;"><svg id="SvgjsSvg1001" width="237" height="100" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1003" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1002"><clipPath id="gridRectMaskwypxcvwr"><rect id="SvgjsRect1007" width="239.5" height="102.5" x="-1.25" y="-1.25" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMaskwypxcvwr"><rect id="SvgjsRect1008" width="239" height="102" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1014" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1015" stop-opacity="0.7" stop-color="rgba(115,103,240,0.7)" offset="0"></stop><stop id="SvgjsStop1016" stop-opacity="0.5" stop-color="rgba(241,240,254,0.5)" offset="0.8"></stop><stop id="SvgjsStop1017" stop-opacity="0.5" stop-color="rgba(241,240,254,0.5)" offset="1"></stop></linearGradient></defs><line id="SvgjsLine1006" x1="39" y1="0" x2="39" y2="100" stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="39" y="0" width="1" height="100" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1020" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1021" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1024" class="apexcharts-grid"><line id="SvgjsLine1026" x1="0" y1="100" x2="237" y2="100" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1025" x1="0" y1="1" x2="0" y2="100" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1010" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1011" class="apexcharts-series" seriesName="Sale" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1018" d="M0 100L0 77.77777777777777C13.825 77.77777777777777 25.675 51.111111111111114 39.5 51.111111111111114C53.325 51.111111111111114 65.175 60 79 60C92.825 60 104.675 24.444444444444443 118.5 24.444444444444443C132.325 24.444444444444443 144.175 55.55555555555556 158 55.55555555555556C171.825 55.55555555555556 183.675 6.666666666666657 197.5 6.666666666666657C211.325 6.666666666666657 223.175 17.777777777777786 237 17.777777777777786C237 17.777777777777786 237 17.777777777777786 237 100M237 17.777777777777786C237 17.777777777777786 237 17.777777777777786 237 17.777777777777786 " fill="url(#SvgjsLinearGradient1014)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskwypxcvwr)" pathTo="M 0 100L 0 77.77777777777777C 13.825 77.77777777777777 25.675 51.111111111111114 39.5 51.111111111111114C 53.325 51.111111111111114 65.175 60 79 60C 92.825 60 104.675 24.444444444444443 118.5 24.444444444444443C 132.325 24.444444444444443 144.175 55.55555555555556 158 55.55555555555556C 171.825 55.55555555555556 183.675 6.666666666666657 197.5 6.666666666666657C 211.325 6.666666666666657 223.175 17.777777777777786 237 17.777777777777786C 237 17.777777777777786 237 17.777777777777786 237 100M 237 17.777777777777786z" pathFrom="M -1 140L -1 140L 39.5 140L 79 140L 118.5 140L 158 140L 197.5 140L 237 140"></path><path id="SvgjsPath1019" d="M0 77.77777777777777C13.825 77.77777777777777 25.675 51.111111111111114 39.5 51.111111111111114C53.325 51.111111111111114 65.175 60 79 60C92.825 60 104.675 24.444444444444443 118.5 24.444444444444443C132.325 24.444444444444443 144.175 55.55555555555556 158 55.55555555555556C171.825 55.55555555555556 183.675 6.666666666666657 197.5 6.666666666666657C211.325 6.666666666666657 223.175 17.777777777777786 237 17.777777777777786C237 17.777777777777786 237 17.777777777777786 237 17.777777777777786 " fill="none" fill-opacity="1" stroke="#7367f0" stroke-opacity="1" stroke-linecap="butt" stroke-width="2.5" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskwypxcvwr)" pathTo="M 0 77.77777777777777C 13.825 77.77777777777777 25.675 51.111111111111114 39.5 51.111111111111114C 53.325 51.111111111111114 65.175 60 79 60C 92.825 60 104.675 24.444444444444443 118.5 24.444444444444443C 132.325 24.444444444444443 144.175 55.55555555555556 158 55.55555555555556C 171.825 55.55555555555556 183.675 6.666666666666657 197.5 6.666666666666657C 211.325 6.666666666666657 223.175 17.777777777777786 237 17.777777777777786" pathFrom="M -1 140L -1 140L 39.5 140L 79 140L 118.5 140L 158 140L 197.5 140L 237 140"></path><g id="SvgjsG1012" class="apexcharts-series-markers-wrap"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1032" r="0" cx="39.5" cy="51.111111111111114" class="apexcharts-marker w447cq9pi no-pointer-events" stroke="#ffffff" fill="#7367f0" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g><g id="SvgjsG1013" class="apexcharts-datalabels"></g></g></g><line id="SvgjsLine1027" x1="0" y1="0" x2="237" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1028" x1="0" y1="0" x2="237" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1029" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1030" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1031" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect1005" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect><g id="SvgjsG1022" class="apexcharts-yaxis" rel="0" transform="translate(-21, 0)"><g id="SvgjsG1023" class="apexcharts-yaxis-texts-g"></g></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip light" style="left: 50px; top: 54px;"><div class="apexcharts-tooltip-series-group active" style="display: flex;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(115, 103, 240);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label">Sale: </span><span class="apexcharts-tooltip-text-value">40</span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-success p-50 m-0">
                            <div class="avatar-content">
                                {{-- <i data-feather='dollar-sign'></i> --}}
                                <img src="{{ asset('assets/images/misc/statistic_3.png') }}" height="20" width="40" alt="Angular" />
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">{{ $data['current_week_sale']. 'K' }}</h2>
                        <p class="card-text">Current Week</p>
                    </div>
                    <div id="current_week">
                        <div id="apexchartsbio3u8ojj" class="apexcharts-canvas apexchartsbio3u8ojj light" style="width: 237px; height: 100px;"><svg id="SvgjsSvg1080" width="237" height="100" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1082" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1081"><clipPath id="gridRectMaskbio3u8ojj"><rect id="SvgjsRect1086" width="239.5" height="102.5" x="-1.25" y="-1.25" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMaskbio3u8ojj"><rect id="SvgjsRect1087" width="239" height="102" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1093" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1094" stop-opacity="0.7" stop-color="rgba(40,199,111,0.7)" offset="0"></stop><stop id="SvgjsStop1095" stop-opacity="0.5" stop-color="rgba(234,249,241,0.5)" offset="0.8"></stop><stop id="SvgjsStop1096" stop-opacity="0.5" stop-color="rgba(234,249,241,0.5)" offset="1"></stop></linearGradient></defs><line id="SvgjsLine1085" x1="0" y1="0" x2="0" y2="100" stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="100" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1099" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1100" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1103" class="apexcharts-grid"><line id="SvgjsLine1105" x1="0" y1="100" x2="237" y2="100" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1104" x1="0" y1="1" x2="0" y2="100" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1089" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1090" class="apexcharts-series" seriesName="Revenue" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1097" d="M0 100L0 60C13.825 60 25.675 90 39.5 90C53.325 90 65.175 40 79 40C92.825 40 104.675 80 118.5 80C132.325 80 144.175 60 158 60C171.825 60 183.675 80 197.5 80C211.325 80 223.175 20 237 20C237 20 237 20 237 100M237 20C237 20 237 20 237 20 " fill="url(#SvgjsLinearGradient1093)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskbio3u8ojj)" pathTo="M 0 100L 0 60C 13.825 60 25.675 90 39.5 90C 53.325 90 65.175 40 79 40C 92.825 40 104.675 80 118.5 80C 132.325 80 144.175 60 158 60C 171.825 60 183.675 80 197.5 80C 211.325 80 223.175 20 237 20C 237 20 237 20 237 100M 237 20z" pathFrom="M -1 200L -1 200L 39.5 200L 79 200L 118.5 200L 158 200L 197.5 200L 237 200"></path><path id="SvgjsPath1098" d="M0 60C13.825 60 25.675 90 39.5 90C53.325 90 65.175 40 79 40C92.825 40 104.675 80 118.5 80C132.325 80 144.175 60 158 60C171.825 60 183.675 80 197.5 80C211.325 80 223.175 20 237 20C237 20 237 20 237 20 " fill="none" fill-opacity="1" stroke="#28c76f" stroke-opacity="1" stroke-linecap="butt" stroke-width="2.5" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskbio3u8ojj)" pathTo="M 0 60C 13.825 60 25.675 90 39.5 90C 53.325 90 65.175 40 79 40C 92.825 40 104.675 80 118.5 80C 132.325 80 144.175 60 158 60C 171.825 60 183.675 80 197.5 80C 211.325 80 223.175 20 237 20" pathFrom="M -1 200L -1 200L 39.5 200L 79 200L 118.5 200L 158 200L 197.5 200L 237 200"></path><g id="SvgjsG1091" class="apexcharts-series-markers-wrap"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1111" r="0" cx="0" cy="60" class="apexcharts-marker wa9j7q4j5 no-pointer-events" stroke="#ffffff" fill="#28c76f" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g><g id="SvgjsG1092" class="apexcharts-datalabels"></g></g></g><line id="SvgjsLine1106" x1="0" y1="0" x2="237" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1107" x1="0" y1="0" x2="237" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1108" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1109" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1110" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect1084" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect><g id="SvgjsG1101" class="apexcharts-yaxis" rel="0" transform="translate(-21, 0)"><g id="SvgjsG1102" class="apexcharts-yaxis-texts-g"></g></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip light" style="left: 11px; top: 63px;"><div class="apexcharts-tooltip-series-group active" style="display: flex;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(40, 199, 111);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label">Revenue: </span><span class="apexcharts-tooltip-text-value">350</span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-danger p-50 m-0">
                            <div class="avatar-content">
                                {{-- <i data-feather='dollar-sign'></i> --}}
                                <img src="{{ asset('assets/images/misc/statistic_1.png') }}" height="20" width="40" alt="Angular" />
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">{{ $data['last_week_sale']. 'K'}}</h2>
                        <p class="card-text">Last 7 Days</p>
                    </div>
                    <div id="last_seven_days">
                        <div id="apexchartsm917sjxaf" class="apexcharts-canvas apexchartsm917sjxaf light" style="width: 237px; height: 100px;"><svg id="SvgjsSvg1080" width="237" height="100" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1082" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1081"><clipPath id="gridRectMaskm917sjxaf"><rect id="SvgjsRect1086" width="239.5" height="102.5" x="-1.25" y="-1.25" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMaskm917sjxaf"><rect id="SvgjsRect1087" width="239" height="102" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1093" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1094" stop-opacity="0.7" stop-color="rgba(234,84,85,0.7)" offset="0"></stop><stop id="SvgjsStop1095" stop-opacity="0.5" stop-color="rgba(253,238,238,0.5)" offset="0.8"></stop><stop id="SvgjsStop1096" stop-opacity="0.5" stop-color="rgba(253,238,238,0.5)" offset="1"></stop></linearGradient></defs><line id="SvgjsLine1085" x1="46.9" y1="0" x2="46.9" y2="100" stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="46.9" y="0" width="1" height="100" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1099" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1100" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1103" class="apexcharts-grid"><line id="SvgjsLine1105" x1="0" y1="100" x2="237" y2="100" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1104" x1="0" y1="1" x2="0" y2="100" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1089" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1090" class="apexcharts-series" seriesName="Sales" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1097" d="M0 100L0 53.33333333333333C16.59 53.33333333333333 30.81 20 47.4 20C63.989999999999995 20 78.21 73.33333333333333 94.8 73.33333333333333C111.39 73.33333333333333 125.61000000000001 40 142.20000000000002 40C158.79000000000002 40 173.01 100 189.6 100C206.19 100 220.41 13.333333333333329 237 13.333333333333329C237 13.333333333333329 237 13.333333333333329 237 100M237 13.333333333333329C237 13.333333333333329 237 13.333333333333329 237 13.333333333333329 " fill="url(#SvgjsLinearGradient1093)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskm917sjxaf)" pathTo="M 0 100L 0 53.33333333333333C 16.59 53.33333333333333 30.81 20 47.4 20C 63.989999999999995 20 78.21 73.33333333333333 94.8 73.33333333333333C 111.39 73.33333333333333 125.61000000000001 40 142.20000000000002 40C 158.79000000000002 40 173.01 100 189.6 100C 206.19 100 220.41 13.333333333333329 237 13.333333333333329C 237 13.333333333333329 237 13.333333333333329 237 100M 237 13.333333333333329z" pathFrom="M -1 120L -1 120L 47.4 120L 94.8 120L 142.20000000000002 120L 189.6 120L 237 120"></path><path id="SvgjsPath1098" d="M0 53.33333333333333C16.59 53.33333333333333 30.81 20 47.4 20C63.989999999999995 20 78.21 73.33333333333333 94.8 73.33333333333333C111.39 73.33333333333333 125.61000000000001 40 142.20000000000002 40C158.79000000000002 40 173.01 100 189.6 100C206.19 100 220.41 13.333333333333329 237 13.333333333333329C237 13.333333333333329 237 13.333333333333329 237 13.333333333333329 " fill="none" fill-opacity="1" stroke="#ea5455" stroke-opacity="1" stroke-linecap="butt" stroke-width="2.5" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskm917sjxaf)" pathTo="M 0 53.33333333333333C 16.59 53.33333333333333 30.81 20 47.4 20C 63.989999999999995 20 78.21 73.33333333333333 94.8 73.33333333333333C 111.39 73.33333333333333 125.61000000000001 40 142.20000000000002 40C 158.79000000000002 40 173.01 100 189.6 100C 206.19 100 220.41 13.333333333333329 237 13.333333333333329" pathFrom="M -1 120L -1 120L 47.4 120L 94.8 120L 142.20000000000002 120L 189.6 120L 237 120"></path><g id="SvgjsG1091" class="apexcharts-series-markers-wrap"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1111" r="0" cx="47.4" cy="20" class="apexcharts-marker wh7f3xdmm no-pointer-events" stroke="#ffffff" fill="#ea5455" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g><g id="SvgjsG1092" class="apexcharts-datalabels"></g></g></g><line id="SvgjsLine1106" x1="0" y1="0" x2="237" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1107" x1="0" y1="0" x2="237" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1108" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1109" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1110" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect1084" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect><g id="SvgjsG1101" class="apexcharts-yaxis" rel="0" transform="translate(-21, 0)"><g id="SvgjsG1102" class="apexcharts-yaxis-texts-g"></g></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip light" style="left: 58px; top: 23px;"><div class="apexcharts-tooltip-series-group active" style="display: flex;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(234, 84, 85);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label">Sales: </span><span class="apexcharts-tooltip-text-value">15</span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-warning p-50 m-0">
                            <div class="avatar-content">
                                {{-- <i data-feather='dollar-sign'></i> --}}
                                <img src="{{ asset('assets/images/misc/statistic_2.png') }}" height="20" width="40" alt="Angular" />
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">{{ $data['last_month_sale']. 'K'}}</h2>
                        <p class="card-text">Last Month</p>
                    </div>
                    <div id="last_month">
                        <div id="apexchartstq5mxj5p" class="apexcharts-canvas apexchartstq5mxj5p light" style="width: 237px; height: 100px;"><svg id="SvgjsSvg1112" width="237" height="100" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1114" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1113"><clipPath id="gridRectMasktq5mxj5p"><rect id="SvgjsRect1118" width="239.5" height="102.5" x="-1.25" y="-1.25" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMasktq5mxj5p"><rect id="SvgjsRect1119" width="239" height="102" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1125" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1126" stop-opacity="0.7" stop-color="rgba(255,159,67,0.7)" offset="0"></stop><stop id="SvgjsStop1127" stop-opacity="0.5" stop-color="rgba(255,245,236,0.5)" offset="0.8"></stop><stop id="SvgjsStop1128" stop-opacity="0.5" stop-color="rgba(255,245,236,0.5)" offset="1"></stop></linearGradient></defs><line id="SvgjsLine1117" x1="39" y1="0" x2="39" y2="100" stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="39" y="0" width="1" height="100" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1131" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1132" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1135" class="apexcharts-grid"><line id="SvgjsLine1137" x1="0" y1="100" x2="237" y2="100" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1136" x1="0" y1="1" x2="0" y2="100" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1121" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1122" class="apexcharts-series" seriesName="Orders" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1129" d="M0 100L0 60C13.825 60 25.675 10 39.5 10C53.325 10 65.175 80 79 80C92.825 80 104.675 10 118.5 10C132.325 10 144.175 90 158 90C171.825 90 183.675 40 197.5 40C211.325 40 223.175 80 237 80C237 80 237 80 237 100M237 80C237 80 237 80 237 80 " fill="url(#SvgjsLinearGradient1125)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMasktq5mxj5p)" pathTo="M 0 100L 0 60C 13.825 60 25.675 10 39.5 10C 53.325 10 65.175 80 79 80C 92.825 80 104.675 10 118.5 10C 132.325 10 144.175 90 158 90C 171.825 90 183.675 40 197.5 40C 211.325 40 223.175 80 237 80C 237 80 237 80 237 100M 237 80z" pathFrom="M -1 160L -1 160L 39.5 160L 79 160L 118.5 160L 158 160L 197.5 160L 237 160"></path><path id="SvgjsPath1130" d="M0 60C13.825 60 25.675 10 39.5 10C53.325 10 65.175 80 79 80C92.825 80 104.675 10 118.5 10C132.325 10 144.175 90 158 90C171.825 90 183.675 40 197.5 40C211.325 40 223.175 80 237 80C237 80 237 80 237 80 " fill="none" fill-opacity="1" stroke="#ff9f43" stroke-opacity="1" stroke-linecap="butt" stroke-width="2.5" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMasktq5mxj5p)" pathTo="M 0 60C 13.825 60 25.675 10 39.5 10C 53.325 10 65.175 80 79 80C 92.825 80 104.675 10 118.5 10C 132.325 10 144.175 90 158 90C 171.825 90 183.675 40 197.5 40C 211.325 40 223.175 80 237 80" pathFrom="M -1 160L -1 160L 39.5 160L 79 160L 118.5 160L 158 160L 197.5 160L 237 160"></path><g id="SvgjsG1123" class="apexcharts-series-markers-wrap"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1143" r="0" cx="39.5" cy="10" class="apexcharts-marker whct9gas7 no-pointer-events" stroke="#ffffff" fill="#ff9f43" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g><g id="SvgjsG1124" class="apexcharts-datalabels"></g></g></g><line id="SvgjsLine1138" x1="0" y1="0" x2="237" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1139" x1="0" y1="0" x2="237" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1140" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1141" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1142" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect1116" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect><g id="SvgjsG1133" class="apexcharts-yaxis" rel="0" transform="translate(-21, 0)"><g id="SvgjsG1134" class="apexcharts-yaxis-texts-g"></g></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip light" style="left: 50px; top: 13px;"><div class="apexcharts-tooltip-series-group active" style="display: flex;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label">Orders: </span><span class="apexcharts-tooltip-text-value">15</span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-12">
                <div class="card card-revenue-budget">
                    {{-- <div class="row mx-0"> --}}
                        <div class="col-md-12 col-12 revenue-report-wrapper">
                            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-50 mb-sm-0">Revenue Report</h4>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center me-2">
                                        <span class="bullet bullet-primary font-small-3 me-50 cursor-pointer"></span>
                                        <span>Earning</span>
                                    </div>
                                    <div class="d-flex align-items-center ms-75">
                                        <span class="bullet bullet-warning font-small-3 me-50 cursor-pointer"></span>
                                        <span>Expense</span>
                                    </div>
                                </div>
                            </div>
                            <div id="ksd-revenue-report-chart"></div>
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>

    </div>
    @endpermission
@endsection
@section('pageJs')
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/cards/card-statistics.min.js') }}"></script>
    <!-- END: Page JS-->
@endsection
@section('script')
<script>
    var sales = [];
    var saleArr = [];

    var expense = [];
    var expArr = [];

    var months = [];
    var monthsArr = [];

    sales  = <?php echo json_encode($data['earnings']); ?>;
    $.each(sales,function(key,val){
        saleArr.push(val);
    });

    expense  = <?php echo json_encode($data['expense']); ?>;
    $.each(expense,function(key,val){
        // console.log(val);
        expArr.push(val);
    });

    var months = <?php echo json_encode($data['categories']); ?>;
    $.each(months,function(key,val){
        var current_month = val.substring(0,3);
        monthsArr.push(current_month);
    });
    // console.log(monthsArr);

    var $revenueReportChart = document.querySelector('#ksd-revenue-report-chart');
    var $textMutedColor = '#b9b9c3';
    revenueReportChartOptions = {
            chart: {
            height: 230,
            stacked: true,
            type: 'bar',
            toolbar: { show: false }
            },
            plotOptions: {
            bar: {
                columnWidth: '17%',
                endingShape: 'rounded'
            },
            distributed: true
            },
            colors: [window.colors.solid.primary, window.colors.solid.warning],
            series: [
            {
                name: 'Earning',
                data: saleArr
            },
            {
                name: 'Expense',
                data: expArr
            }
            ],
            dataLabels: {
            enabled: false
            },
            legend: {
            show: false
            },
            grid: {
            padding: {
                top: -20,
                bottom: -10
            },
            yaxis: {
                lines: { show: false }
            }
            },
            xaxis: {
            categories: monthsArr,
            labels: {
                style: {
                colors: $textMutedColor,
                fontSize: '0.86rem'
                }
            },
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
            },
            yaxis: {
            labels: {
                style: {
                colors: $textMutedColor,
                fontSize: '0.86rem'
                }
            }
            }
        };
  revenueReportChart = new ApexCharts($revenueReportChart, revenueReportChartOptions);
  revenueReportChart.render();

</script>
@endsection

