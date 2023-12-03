@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            Dashboard
        </div>
    </div>

    <div class="row">
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-primary">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold">{{$appointments->count()}} <span class="fs-6 fw-normal"></span></div>
                    <div>Appointments</div>
                  </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                  <canvas class="chart" id="card-chart1" height="70" width="265" style="display: block; box-sizing: border-box; height: 70px; width: 265px;"></canvas>
                </div>
              </div>
            </div>

            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-warning">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold">{{$inventory_items->count()}} <span class="fs-6 fw-normal"></span></div>
                    <div>Inventory Items</div>
                  </div>
                </div>
                <div class="c-chart-wrapper mt-3" style="height:70px;">
                  <canvas class="chart" id="card-chart3" height="70" width="297" style="display: block; box-sizing: border-box; height: 70px; width: 297px;"></canvas>
                </div>
              </div>
            </div>

            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-danger">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold">{{$yards->count()}} <span class="fs-6 fw-normal"></span></div>
                    <div>Yards</div>
                  </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                  <canvas class="chart" id="card-chart4" height="70" width="265" style="display: block; box-sizing: border-box; height: 70px; width: 265px;"></canvas>
                </div>
              </div>
            </div>
            <!-- /.col-->

            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-info">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold"> 
                    {{$at_bay->count()}}<span class="fs-6 fw-normal"></span>
                    </div>
                    <div>Bay Operations</div>
                  </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                  <canvas class="chart" id="card-chart2" height="70" width="265" style="display: block; box-sizing: border-box; height: 70px; width: 265px;"></canvas>
                </div>
              </div>
            </div>

            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-info">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold"> 
                    {{$waiting_to_load->count()}}<span class="fs-6 fw-normal"></span>
                    </div>
                    <div>Waiting to Load</div>
                  </div>
                </div>
                <div class="c-chart-wrapper" style="height:30px;">
                  <canvas class="chart" id="card-chart2" height="70" width="265" style="display: block; box-sizing: border-box; height: 70px; width: 265px;"></canvas>
                </div>
              </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-success">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold"> 
                    {{$loading->count()}}<span class="fs-6 fw-normal"></span>
                    </div>
                    <div>Loading</div>
                  </div>
                </div>
                <div class="c-chart-wrapper" style="height:30px;">
                  <canvas class="chart" id="card-chart2" height="70" width="265" style="display: block; box-sizing: border-box; height: 70px; width: 265px;"></canvas>
                </div>
              </div>
            </div>

            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-info">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold"> 
                    {{$waiting_to_offload->count()}}<span class="fs-6 fw-normal"></span>
                    </div>
                    <div>Waiting to OffLoad</div>
                  </div>
                </div>
                <div class="c-chart-wrapper" style="height:30px;">
                  <canvas class="chart" id="card-chart2" height="70" width="265" style="display: block; box-sizing: border-box; height: 70px; width: 265px;"></canvas>
                </div>
              </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-info">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold"> 
                    {{$offloading->count()}}<span class="fs-6 fw-normal"></span>
                    </div>
                    <div>OffLoading</div>
                  </div>
                </div>
                <div class="c-chart-wrapper" style="height:30px;">
                  <canvas class="chart" id="card-chart2" height="70" width="265" style="display: block; box-sizing: border-box; height: 70px; width: 265px;"></canvas>
                </div>
              </div>
            </div>




    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.systemCalendar') }}
                </div> 

                <div class="card-body">
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css'/>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')

 @parent
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script>
      $(document).ready(function () {
        // page is now ready, initialize the calendar...
        events ={!! json_encode($events) !!};
        $('#calendar').fullCalendar({
          // put your options and callbacks here
          events: events,
          defaultView: 'agendaWeek'
        })
      })
    </script>
@parent

@endsection