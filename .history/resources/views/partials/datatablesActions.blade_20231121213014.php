@can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan

@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan

@can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan

@if (isset($admitAppointmentGate))
    @can($admitAppointmentGate)
        @if ($row->status == 'pending')
            <form action="{{ route('admin.' . $crudRoutePart . '.admit') }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{$row->id}}">
                <input type="submit" class="btn btn-xs btn-dark" value="{{ trans('global.admit') }}">
            </form>
        @endif
    @endcan
@endif

@if (isset($printPassAppointmentGate))
    @can($printPassAppointmentGate)
        @if ($row->status == 'finished_loading')
            <form action="{{ route('admin.' . $crudRoutePart . '.printpass') }}" method="POST" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="appointment_id" value="{{$row->id}}">
                <input type="hidden" name="ref" value="{{@$row->gate_pass->ref}}">
                {{-- <input type="submit" class="btn btn-xs btn-default" value="{{ trans('global.gate_pass') }}"> --}}
                <button type="submit" class="btn btn-xs btn-default">
                    <i class="fa-fw fas fa-print nav-icon"></i> Print {{ trans('global.gate_pass') }}
                </button>
            </form>
        @endif
    @endcan
@endif

@if (isset($loadingbayStartGate))
    @can($loadingbayStartGate)
        @if ($row->status == 'waiting')
            <form action="{{ route('admin.' . $crudRoutePart . '.start') }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{$row->id}}">
                <input type="submit" class="btn btn-xs btn-success" value="{{ trans('global.start') }} {{ucwords($row->type)}}">
            </form>
        @endif
    @endcan
@endif

@if (isset($loadingbayFinishGate))
    @can($loadingbayFinishGate)
        @if ($row->status == 'started_'.$row->type)
            <form action="{{ route('admin.' . $crudRoutePart . '.finish') }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{$row->id}}">
                <input type="submit" class="btn btn-xs btn-dark" value="{{ trans('global.finish') }} {{ucwords($row->type)}}">
            </form>
        @endif
    @endcan
@endif