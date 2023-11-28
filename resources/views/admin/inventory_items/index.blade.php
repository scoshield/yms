@extends('layouts.admin')
@section('content')
    @can('inventory_item_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.inventory_items.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.inventory_item.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.inventory_item.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-InventoryItem">
                <thead>
                    <tr>
                        <th width="10"> </th>
                        <th>{{ trans('cruds.inventory_item.fields.id') }} </th>
                        <th>{{ trans('cruds.inventory_item.fields.category') }} </th>
                        <th>{{ trans('cruds.inventory_item.fields.ref') }}</th>
                        <th>{{ trans('cruds.inventory_item.fields.yard') }}</th>
                        <th>{{ trans('cruds.inventory_item.fields.department') }}</th>
                        <th>{{ trans('cruds.inventory_item.fields.size') }}</th>

                        <th>{{ trans('cruds.inventory_item.fields.status') }}</th>
                        <th>{{ trans('cruds.inventory_item.fields.structural_status') }}</th>
                        <th>{{ trans('cruds.inventory_item.fields.inspected') }}</th>
                        <th>{{ trans('cruds.inventory_item.fields.refurbished') }}</th>
                        <th>{{ trans('cruds.inventory_item.fields.cnumbers_visible') }}</th>
                        <th>{{ trans('cruds.inventory_item.fields.year_manufactured') }}</th>
                        <th>{{ trans('cruds.inventory_item.fields.type') }}</th>
                        <th>{{ trans('cruds.inventory_item.fields.remarks') }}</th>

                        <th>{{ trans('cruds.inventory_item.fields.creator') }}</th>
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
            @can('inventory_item_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.inventory_items.massDestroy') }}",
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
                "columnDefs": [{
                    "targets": [10, 11, 12],
                    "visible": false,
                    "searchable": false
                }],
                scrollX: true,
                ajax: "{{ route('admin.inventory_items.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'ref',
                        name: 'ref'
                    },
                    {
                        data: 'yard_name',
                        name: 'yard_name'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'structural_status',
                        name: 'structural_status'
                    },
                    {
                        data: 'inspected',
                        name: 'inspected'
                    },
                    {
                        data: 'refurbished',
                        name: 'refurbished'
                    },
                    {
                        data: 'cnumbers_visible',
                        name: 'cnumbers_visible'
                    },
                    {
                        data: 'year_manufactured',
                        name: 'year_manufactured'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'remarks',
                        name: 'remarks'
                    },
                    {
                        data: 'creator_name',
                        name: 'creator_name'
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
            $('.datatable-InventoryItem').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });
    </script>
@endsection
