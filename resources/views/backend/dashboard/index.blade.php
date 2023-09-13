@extends('backend.layouts.app')
@section('content')
<div class="wrapper">
    <div class="main-panel">
        <div class="main-content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <section id="minimal-statistics">
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12"></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h1 class="content-header">
                                <b>Welcome to Yatharth Geeta Admin Panel</b>
                            </h1>
                            <hr style="border: none; border-bottom: 1px solid black;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-center">
                            <img src="{{ asset('backend/img/dashboard/guru1.png') }}" alt="ashram" class="img-fluid">
                        </div>
                        <div class="col-4 text-center">
                            <img src="{{ asset('backend/img/dashboard/om_logo.png') }}" alt="ashram" class="img-fluid">
                        </div>
                        <div class="col-4 text-center">
                            <img src="{{ asset('backend/img/dashboard/guru2.png') }}" alt="ashram" class="img-fluid">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $users_total }}</h3>
                                                <span>Total Users</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $books_total }}</h3>
                                                <span>Total Books</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $audios_total }}</h3>
                                                <span>Total Audio</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $videos_total }}</h3>
                                                <span>Total Video</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 warning">{{ $locations_total }}</h3>
                                                <span>Total Locations</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-file-audio-o warning font-large-2" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 danger">3</h3>
                                                <span>Total Shlokas</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-file-video-o danger font-large-2" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $mantras_total }}</h3>
                                                <span>Total Mantras</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 primary">{{ $greetings_total }}</h3>
                                                <span>Total Greetings</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-newspaper-o font-large-2 primary" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="graph" class="shadow rounded-lg"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

$(document).ready(function () {
    var user_data = <?php echo json_encode($user_data); ?>;
    var user_count = [];
    var user_month = [];
    for (var i = 0; i < user_data.length; i++) {
        user_count.push(user_data[i].count);
        user_month.push(user_data[i].month);
    }
    Highcharts.chart('graph', {
        chart: {
            type: 'column',
        },
        title: {
            text: "Yatharth Geeta's App Users"
        },
        xAxis: {
            title: {
                text: '<b>Users Registered in Last 6 Months</b>',
                style: {
                    fontSize: '15px',
                }
            },
            categories: user_month
        },
        yAxis: {
            title: {
                text: '<b>Number of Users</b>',
                style: {
                    fontSize: '15px',
                }
            },
            lineWidth: 1
        },
        plotOptions: {
            column: {
                pointWidth: 50,
                color: '#E49C28'
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'Users',
            data: user_count
        }]
    });
});

</script>

@endsection
