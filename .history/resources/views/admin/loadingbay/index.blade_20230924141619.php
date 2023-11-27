@extends('layouts.admin')
@section('content')
    @can('loadingbay_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.loadingbay.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.loadingbay.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.loadingbay.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Hauler">
                <thead>
                    <tr>
                        <th width="10"> </th>
                        <th>{{ trans('cruds.loadingbay.fields.id') }} </th>
                        <th>{{ trans('cruds.loadingbay.fields.type') }} </th>
                        <th>{{ trans('cruds.loadingbay.fields.appointment') }}</th>
                        <th>{{ trans('cruds.loadingbay.fields.status') }}</th>
                        <th>{{ trans('cruds.loadingbay.fields.created_at') }}</th>
                        <th>{{ trans('cruds.loadingbay.fields.started_at') }}</th>
                        <th>{{ trans('cruds.loadingbay.fields.finished_at') }}</th>
                        <th>{{ trans('cruds.loadingbay.fields.duration') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
            </table>


        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('loadingbay_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.loadingbay.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).data(), function(entry) {
                            return entry.id
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.loadingbay.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'appointment',
                        name: 'appointment'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'started_at',
                        name: 'started_at'
                    },
                    {
                        data: 'finished_at',
                        name: 'finished_at'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            };
            $('.datatable-Hauler').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });
    </script>
@endsection
