<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('panel.site_title') }}</title>
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" /> --}}
    <link href="{{asset('resources/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('resources/all.css')}}" rel="stylesheet" />
    <link href="{{asset('resources/jquery.dataTables.min.css')}}" rel="stylesheet" />
    <link href="{{asset('resources/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('resources/buttons.dataTables.min.css')}}" rel="stylesheet" />
    <link href="{{asset('resources/select.dataTables.min.css')}}" rel="stylesheet" />
    <link href="{{asset('resources/coreui.min.css')}}" rel="stylesheet" />
    <link href="{{asset('resources/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('resources/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
    <link href="{{asset('resources/dropzone.min.css')}}" rel="stylesheet" />
    <link href="{{asset('resources/custom.css') }}" rel="stylesheet" />
    @yield('styles')
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="navbar-brand-full">{{ trans('panel.site_title') }}</span>
            <span class="navbar-brand-minimized">{{ trans('panel.site_title') }}</span>
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="nav navbar-nav ml-auto">
            @if(count(config('panel.available_languages', [])) > 1)
                <li class="nav-item dropdown d-md-down-none">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach(config('panel.available_languages') as $langLocale => $langName)
                            <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                        @endforeach
                    </div>
                </li>
            @endif
        </ul>
    </header>

    <div class="app-body">
        @include('partials.menu')
        <main class="main">


            <div style="padding-top: 20px" class="container-fluid">
                @if(session('message'))
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                @endif
                @if($errors->count() > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')

            </div>


        </main>
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
    <script src="{{asset('resources') }}/jquery.min.js"></script>
    <script src="{{asset('resources') }}/bootstrap.min.js"></script>
    <script src="{{asset('resources') }}/popper.min.js"></script>
    <script src="{{asset('resources') }}/coreui.min.js"></script>
    <script src="{{asset('resources') }}/jquery.dataTables.min.js"></script>
    <script src="{{asset('resources') }}/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('resources') }}/dataTables.buttons.min.js"></script>
    <script src="{{asset('resources') }}/buttons.flash.min.js"></script>
    <script src="{{asset('resources') }}/buttons.html5.min.js"></script>
    <script src="{{asset('resources') }}/buttons.print.min.js"></script>
    <script src="{{asset('resources') }}/buttons.colVis.min.js"></script>
    <script src="{{asset('resources') }}/pdfmake.min.js"></script>
    <script src="{{asset('resources') }}/vfs_fonts.js"></script>
    <script src="{{asset('resources') }}/jszip.min.js"></script>
    <script src="{{asset('resources') }}/dataTables.select.min.js"></script>
    <script src="{{asset('resources') }}/ckeditor.js"></script>
    <script src="{{asset('resources') }}/moment.min.js"></script>
    <script src="{{asset('resources') }}/bootstrap-datetimepicker.min.js"></script>
    <script src="{{asset('resources') }}/select2.full.min.js"></script>
    <script src="{{asset('resources') }}/dropzone.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function() {
  let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
  let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
  let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
  let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
  let printButtonTrans = '{{ trans('global.datatables.print') }}'
  let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'

  let languages = {
    'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
  };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      url: languages['{{ app()->getLocale() }}']
    },
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
    }, {
        orderable: false,
        searchable: false,
        targets: -1
    }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
    order: [],
    scrollX: true,
    pageLength: 100,
    dom: 'lBfrtip<"actions">',
    buttons: [
      {
        extend: 'copy',
        className: 'btn-default',
        text: copyButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        className: 'btn-default',
        text: csvButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn-default',
        text: excelButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        className: 'btn-default',
        text: pdfButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        className: 'btn-default',
        text: printButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'colvis',
        className: 'btn-default',
        text: colvisButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';
});

    </script>
    @yield('scripts')
</body>

</html>
