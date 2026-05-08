@extends('layouts.master')

@section('title', __('Edit Project'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.projects.index') }}">{{ __('Projects') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.projects.update', $project->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row p-5">
                        <h3>{{ __('Edit Project') }}</h3>
                        <div class="mb-4 col-md-12">
                            <label for="name" class="form-label">{{ __('Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                name="name" required placeholder="{{ __('Enter name') }}" autofocus
                                value="{{ old('name', $project->name) }}" />
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                placeholder="{{ __('Enter description') }}" cols="30" rows="10">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="main_image" class="form-label">{{ __('Main Logo') }}</label>
                            <input class="form-control @error('main_image') is-invalid @enderror" type="file"
                                id="main_image" name="main_image" accept="image/*" />
                            @error('main_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if ($project->main_image)
                                <img src="{{ asset($project->main_image) }}" alt="Main Image" width="150">
                            @endif
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="water_mark_image" class="form-label">{{ __('Water Mark Logo') }}</label>
                            <input class="form-control @error('water_mark_image') is-invalid @enderror" type="file"
                                id="water_mark_image" name="water_mark_image" accept="image/*" />
                            @error('water_mark_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if ($project->water_mark_image)
                                <img src="{{ asset($project->water_mark_image) }}" alt="Main Image" width="150">
                            @endif
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" id="address"
                                name="address" value="{{ old('address', $project->address) }}" placeholder="{{ __('Enter address') }}" />
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Edit Project') }}</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
@endsection

@section('script')
@endsection
