@extends('layouts.master')

@section('title', __('Edit Plot'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.plots.index') }}">{{ __('Plots') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit Plot') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.plots.update', $plot->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row p-5">
                        <h3>{{ __('Edit Plot') }}</h3>
                        <div class="mb-4 col-md-6">
                            <label for="project_id" class="form-label">{{ __('Project') }}</label><span
                                class="text-danger">*</span>
                            <select name="project_id" class="form-select select2 @error('project_id') is-invalid @enderror"
                                id="project_id" required>
                                <option value="" selected disabled>Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id', $plot->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}
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
                            <label for="block" class="form-label">{{ __('Block') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('block') is-invalid @enderror" type="text" id="block"
                                name="block" required placeholder="{{ __('Enter block') }}"
                                value="{{ old('block', $plot->block) }}" />
                            @error('block')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="plot_no" class="form-label">{{ __('Plot No') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('plot_no') is-invalid @enderror" type="text" id="plot_no"
                                name="plot_no" required placeholder="{{ __('Enter plot no') }}"
                                value="{{ old('plot_no', $plot->plot_no) }}" />
                            @error('plot_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="size" class="form-label">{{ __('Plot Size') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('size') is-invalid @enderror" type="text" id="size"
                                name="size" required placeholder="{{ __('Enter plot size') }}"
                                value="{{ old('size', $plot->size) }}" />
                            @error('size')
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
                                <option value="residential" {{ old('category', $plot->category) == 'residential' ? 'selected' : '' }}>
                                    Residential</option>
                                <option value="commercial" {{ old('category', $plot->category) == 'commercial' ? 'selected' : '' }}>
                                    Commercial</option>
                                <option value="industrial" {{ old('category', $plot->category) == 'industrial' ? 'selected' : '' }}>
                                    Industrial</option>
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="price" class="form-label">{{ __('Plot Price') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('price') is-invalid @enderror" type="number" step="any" id="price"
                                name="price" required placeholder="{{ __('Enter plot price') }}"
                                value="{{ old('price', $plot->price) }}" />
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            @php
                                $hasExtras = $plot->extras && $plot->extras->count() > 0;
                                $oldHasExtras = old('has_extras', $hasExtras);
                            @endphp
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="has_extras" name="has_extras" value="1"
                                    {{ $oldHasExtras ? 'checked' : '' }}>
                                <label class="form-check-label" for="has_extras">
                                    Add Plot Extras (Corner, West Open, Park Facing, Main Road Facing, etc.)
                                </label>
                            </div>

                            <div id="extras-section" style="{{ $oldHasExtras ? 'display: block;' : 'display: none;' }}">
                                <div class="row" id="extra-wrapper">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="extra" class="form-label">Plot Extras</label>
                                            <button type="button" id="add-extra" class="btn btn-primary btn-sm float-end">
                                                <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i> Add More
                                            </button>
                                        </div>
                                    </div>

                                    @php
                                        // Get existing extras from the relationship
                                        $existingExtras = $plot->extras;
                                        $oldExtraKeys = old('extra_key', []);
                                        $oldExtraValues = old('extra_value', []);

                                        // Determine which extras to display
                                        if (count($oldExtraKeys) > 0) {
                                            // Use old input if available (after validation error)
                                            $displayExtras = [];
                                            foreach ($oldExtraKeys as $index => $key) {
                                                if (!empty($key)) {
                                                    $displayExtras[] = [
                                                        'key' => $key,
                                                        'value' => $oldExtraValues[$index] ?? ''
                                                    ];
                                                }
                                            }
                                        } elseif ($existingExtras && $existingExtras->count() > 0) {
                                            // Use existing extras from database
                                            $displayExtras = $existingExtras->toArray();
                                        } else {
                                            // Default 4 extras
                                            $displayExtras = [
                                                ['key' => 'Corner', 'value' => ''],
                                                ['key' => 'West Open', 'value' => ''],
                                                ['key' => 'Park Facing', 'value' => ''],
                                                ['key' => 'Main Road Facing', 'value' => '']
                                            ];
                                        }
                                    @endphp

                                    @foreach ($displayExtras as $index => $extra)
                                        <div class="mb-4 col-md-12 amenity-item">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="extra_key[]"
                                                    placeholder="Extra name (e.g., Corner)"
                                                    value="{{ $extra['key'] ?? $extra->key ?? '' }}" />
                                                <input class="form-control" type="text" name="extra_value[]"
                                                    placeholder="Amount (e.g., +5,000)"
                                                    value="{{ $extra['value'] ?? $extra->value ?? '' }}" />
                                                <button type="button" class="btn btn-danger remove-btn">
                                                    <i class="ti ti-trash me-0 me-sm-1 ti-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                placeholder="{{ __('Enter description') }}" cols="30" rows="10">{{ old('description', $plot->description) }}</textarea>
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
                            @if ($plot->image)
                                <img src="{{ asset($plot->image) }}" alt="Plot Image" width="150">
                            @endif
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Update Plot') }}</button>
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
            });

            // Remove extra field
            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.amenity-item').remove();
            });
        });
    </script>
@endsection
