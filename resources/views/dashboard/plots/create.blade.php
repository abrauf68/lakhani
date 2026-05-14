@extends('layouts.master')

@section('title', __('Create Plot'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.plots.index') }}">{{ __('Plots') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.plots.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row p-5">
                        <h3>{{ __('Add New Plot') }}</h3>
                        <div class="mb-4 col-md-6">
                            <label for="project_id" class="form-label">{{ __('Project') }}</label><span
                                class="text-danger">*</span>
                            <select name="project_id" class="form-select select2 @error('project_id') is-invalid @enderror"
                                id="project_id" required>
                                <option value="" selected disabled>Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="category" class="form-label">{{ __('Category') }}</label><span
                                class="text-danger">*</span>
                            <select name="category" class="form-select select2 @error('category') is-invalid @enderror"
                                id="category" required>
                                <option value="">Select Category</option>
                                <option value="residential" {{ old('category') == 'residential' ? 'selected' : '' }}>
                                    Residential</option>
                                <option value="commercial" {{ old('category') == 'commercial' ? 'selected' : '' }}>
                                    Commercial</option>
                                <option value="industrial" {{ old('category') == 'industrial' ? 'selected' : '' }}>
                                    Industrial</option>
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="block" class="form-label">{{ __('Block') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('block') is-invalid @enderror" type="text" id="block"
                                name="block" required placeholder="{{ __('Enter block') }}"
                                value="{{ old('block') }}" />
                            @error('block')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="plot_no" class="form-label">{{ __('Plot No') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('plot_no') is-invalid @enderror" type="text" id="plot_no"
                                name="plot_no" required placeholder="{{ __('Enter plot no') }}"
                                value="{{ old('plot_no') }}" />
                            @error('plot_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="size" class="form-label">{{ __('Plot Size') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('size') is-invalid @enderror" type="text" id="size"
                                name="size" required placeholder="{{ __('Enter plot size') }}"
                                value="{{ old('size') }}" />
                            @error('size')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- <div class="mb-4 col-md-12">
                            <div class="row" id="extra-wrapper">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="extra" class="form-label">Extra <span
                                                class="text-danger">*</span></label>
                                        <button type="button" id="add-extra" class="btn btn-primary btn-sm float-end">
                                            <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i> Add More
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-4 col-md-12 amenity-item">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="extra[]" required
                                            placeholder="Enter extra" />
                                        <button type="button" class="btn btn-danger remove-btn d-none"><i
                                                class="ti ti-trash me-0 me-sm-1 ti-xs"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="mb-4 col-md-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="has_extras" name="has_extras" value="1"
                                    {{ old('has_extras') ? 'checked' : '' }}>
                                <label class="form-check-label" for="has_extras">
                                    Add Plot Extras (Corner, West Open, Park Facing, Main Road Facing, etc.)
                                </label>
                            </div>

                            <div id="extras-section" style="{{ old('has_extras') ? 'display: block;' : 'display: none;' }}">
                                <div class="row" id="extra-wrapper">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="extra" class="form-label">Plot Extras</label>
                                            <button type="button" id="add-extra" class="btn btn-primary btn-sm float-end">
                                                <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i> Add More
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Pre-filled extras -->
                                    <div class="mb-4 col-md-12 amenity-item">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="extra_key[]" placeholder="Extra name (e.g., Corner)" value="Corner" />
                                            <input class="form-control" type="text" name="extra_value[]" placeholder="Amount (e.g., +5,000)" value="" />
                                            <button type="button" class="btn btn-danger remove-btn"><i class="ti ti-trash me-0 me-sm-1 ti-xs"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-12 amenity-item">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="extra_key[]" placeholder="Extra name (e.g., West Open)" value="West Open" />
                                            <input class="form-control" type="text" name="extra_value[]" placeholder="Amount (e.g., +5,000)" value="" />
                                            <button type="button" class="btn btn-danger remove-btn"><i class="ti ti-trash me-0 me-sm-1 ti-xs"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-12 amenity-item">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="extra_key[]" placeholder="Extra name (e.g., Park Facing)" value="Park Facing" />
                                            <input class="form-control" type="text" name="extra_value[]" placeholder="Amount (e.g., +5,000)" value="" />
                                            <button type="button" class="btn btn-danger remove-btn"><i class="ti ti-trash me-0 me-sm-1 ti-xs"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-12 amenity-item">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="extra_key[]" placeholder="Extra name (e.g., Main Road Facing)" value="Main Road Facing" />
                                            <input class="form-control" type="text" name="extra_value[]" placeholder="Amount (e.g., +5,000)" value="" />
                                            <button type="button" class="btn btn-danger remove-btn"><i class="ti ti-trash me-0 me-sm-1 ti-xs"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6 class="italic"><i>Pricings & Installments</i></h6>
                        <div class="mb-4 col-md-12">
                            <label for="price" class="form-label">{{ __('Plot Total Price') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('price') is-invalid @enderror" type="number" step="any" id="price"
                                name="price" required placeholder="{{ __('Enter plot price') }}"
                                value="{{ old('price') }}" />
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                placeholder="{{ __('Enter description') }}" cols="30" rows="10">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="image" class="form-label">{{ __('Image') }}</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file"
                                id="image" name="image" accept="image/*" />
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Add Plot') }}</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Toggle extras section on checkbox change
            $('#has_extras').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#extras-section').slideDown();
                } else {
                    $('#extras-section').slideUp();
                    // Optionally clear all extra fields when hiding
                    $('#extra-wrapper').find('input').val('');
                }
            });

            // Add new extra field
            $('#add-extra').on('click', function() {
                let newField = `
                <div class="mb-4 col-md-12 amenity-item">
                    <div class="input-group">
                        <input class="form-control" type="text" name="extra_key[]" placeholder="Extra name (e.g., Corner)" />
                        <input class="form-control" type="text" name="extra_value[]" placeholder="Amount (e.g., +5,000)" />
                        <button type="button" class="btn btn-danger remove-btn"><i class="ti ti-trash me-0 me-sm-1 ti-xs"></i></button>
                    </div>
                </div>`;
                $('#extra-wrapper').append(newField);
                // Remove buttons are always visible, no need to toggle
            });

            // Remove extra field
            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.amenity-item').remove();
            });
        });
    </script>
@endsection
