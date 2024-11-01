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
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST"
        onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan

@if (isset($hodAppointmentGate))
    @can($hodAppointmentGate)
        @if ($row->status == 'pending')
            <form action="{{ route('admin.' . $crudRoutePart . '.approve') }}" method="POST"
                onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="hidden" name='approval_type' value="hod" />
                <input type="submit" class="btn btn-xs btn-dark" value="{{ trans('global.hod_approve') }}">
            </form>
        @endif
    @endcan
@endif

@if (isset($securityAppointmentGate))
    @can($securityAppointmentGate)
        @if ($row->status == 'hod_approved')
            <form action="{{ route('admin.' . $crudRoutePart . '.approve') }}" method="POST"
                onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="hidden" name='approval_type' value="security" />
                <input type="submit" class="btn btn-xs btn-dark" value="{{ trans('global.security_approve') }}">
            </form>
        @endif
    @endcan
@endif

@if (isset($admitAppointmentGate))
    @can($admitAppointmentGate)
        @if ($row->status == 'security_approved')
            {{-- <form action="{{ route('admin.' . $crudRoutePart . '.admit') }}" method="POST"
                onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="submit" class="btn btn-xs btn-dark" value="{{ trans('global.admit') }}">
            </form> --}}
            <a href="{{ route('admin.appointment.gatein', $row->id)}}" class="btn btn-xs btn-dark">Admit</a>
        @endif
    @endcan
@endif

@if (isset($appointmentGateout))
    @can($appointmentGateout)
        @if ($row->process_done == 1 && !$row->gateout)
            <form action="{{ route('admin.' . $crudRoutePart . '.gateout') }}" method="POST"
                onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="submit" class="btn btn-xs btn-dark" value="{{ trans('global.gateout') }}">
            </form>
        @endif
    @endcan
@endif

@if (isset($printPassAppointmentGate))
    @can($printPassAppointmentGate)
        @if (in_array($row->status, [
                'finished_loading',
                'finished_offloading',
                'finished_offloading_and_loading',
                'finished_cross_stuff',
                'security_approved',
                'gateout',
                'admitted'
            ]))
            <form action="{{ route('admin.' . $crudRoutePart . '.printpass') }}" method="POST"
                style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="appointment_id" value="{{ $row->id }}">
                <input type="hidden" name="pass_ref" value="{{ @$row->gate_pass->ref }}">
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
            {{-- <form action="{{ route('admin.' . $crudRoutePart . '.start') }}" method="POST"
                onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="submit" class="btn btn-xs btn-success"
                    value="{{ trans('global.start') }} {{ ucwords($row->type) }}">
            </form> --}}
            <a href="{{ route('admin.loading.start', $row->id)}}" class="btn btn-xs btn-dark">{{ trans('global.start') }} {{ ucwords($row->type) }}</a>
        @endif
    @endcan
@endif

@if (isset($loadingbayFinishGate))
    @can($loadingbayFinishGate)
        @if ($row->status == 'started_' . $row->type)
            {{-- <form action="{{ route('admin.' . $crudRoutePart . '.finish') }}" method="POST"
                onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="submit" class="btn btn-xs btn-dark"
                    value="{{ trans('global.finish') }} {{ ucwords($row->type) }}">
            </form> --}}
            <a href="{{ route('admin.loading.end', $row->id)}}" class="btn btn-xs btn-dark">{{ trans('global.finish') }} {{ ucwords($row->type) }}</a>
        @endif
    @endcan
@endif

{{-- @if (isset($loadingbayFinishGate))
    @can($loadingbayFinishGate)
        @if ($row->status == 'started_' . $row->type) --}}
            {{-- <form action="{{ route('admin.' . $crudRoutePart . '.finish') }}" method="POST"
                onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="submit" class="btn btn-xs btn-dark"
                    value="{{ trans('global.finish') }} {{ ucwords($row->type) }}">
            </form> --}}
            {{-- <a href="{{ route('admin.loading.end', $row->id)}}" class="btn btn-xs btn-dark">{{ trans('global.finish') }} {{ ucwords($row->type) }}</a>
        @endif
    @endcan
@endif --}}

@if (isset($checkoutInventoryItemGate))
    @if ($row->status !== 'checked_out')
        @can($checkoutInventoryItemGate)
            <form action="{{ route('admin.' . $crudRoutePart . '.checkout') }}" method="POST"
                onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="submit" class="btn btn-xs btn-dark" value="{{ trans('global.checkout') }}">
            </form>
            
        @endcan
    @endif
@endif

{{-- inventory_item_checkout --}}
