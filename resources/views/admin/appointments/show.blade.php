@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Appointment Details
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                Date & Time
                            </th>
                            <td>
                                {{ $appointment->appointment_date }}
                            </td>
                        </tr>
                        <tr>
                            <th> Purpose </th>
                            <td> {{ $appointment->purpose ?? '' }} </td>
                        </tr>
                        <tr>
                            <th>
                                Yard
                            </th>
                            <td>
                                {{ $appointment->yard->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Hauler
                            </th>
                            <td>
                                {{ $appointment->hauler->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Created By
                            </th>
                            <td>
                                {{ $appointment->creator->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                File Number
                            </th>
                            <td>
                                {{ $appointment->file_number }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Remarks/Comments
                            </th>
                            <td>
                                {!! $appointment->comments !!}
                            </td>
                        </tr>

                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>


        </div>
    </div>
@endsection
