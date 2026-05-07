@extends('layouts.master')

@section('title', __('Plots'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Plots') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Plots List Table -->
        <div class="card">
            <div class="card-header">
                @canany(['create plot'])
                    <a href="{{route('dashboard.plots.create')}}" class="add-new btn btn-primary waves-effect waves-light">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                            class="d-none d-sm-inline-block">{{ __('Add New Plot') }}</span>
                    </a>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Project') }}</th>
                            <th>{{ __('Block') }}</th>
                            <th>{{ __('Plot No') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Status') }}</th>
                            @canany(['delete plot', 'update plot'])<th>{{ __('Action') }}</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plots as $index => $plot)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $plot->project->name }}</td>
                                <td>{{ $plot->block ?? 'N/A' }}</td>
                                <td>{{ $plot->plot_no }}</td>
                                <td>{{ ucfirst($plot->category) }}</td>
                                <td>
                                    <span class="badge me-4 bg-label-{{ $plot->status == 'sold' ? 'success' : 'warning' }}">{{ ucfirst($plot->status) }}</span>
                                </td>
                                @canany(['delete plot', 'update plot'])
                                    <td class="d-flex">
                                        @canany(['delete plot'])
                                            <form action="{{ route('dashboard.plots.destroy', $plot->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="#" type="submit"
                                                    class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Delete Plot') }}">
                                                    <i class="ti ti-trash ti-md"></i>
                                                </a>
                                            </form>
                                        @endcan
                                        @canany(['update plot'])
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.plots.edit', $plot->id) }}"
                                                    class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Edit Plot') }}">
                                                    <i class="ti ti-edit ti-md"></i>
                                                </a>
                                            </span>
                                        @endcan
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script src="{{asset('assets/js/app-user-list.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            //
        });
    </script>
@endsection
