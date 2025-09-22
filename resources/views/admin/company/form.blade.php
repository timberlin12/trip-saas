@extends('layouts.app')

@section('toolbar')
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">
                {{ $company->exists ? 'Edit Company' : 'Add New Company' }}
            </h1>
            <span class="h-20px border-gray-300 border-start mx-4"></span>
            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-300 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-dark">Companies</li>
            </ul>
        </div>
        <div class="d-flex align-items-center py-1">
            <a href="{{ route('companies.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid mt-14">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-5 m-5">

            <form method="POST" action="{{ route('companies.storeOrUpdate') }}" class="row g-4" enctype="multipart/form-data">
                @csrf
                @if($company->exists)
                    <input type="hidden" name="id" value="{{ $company->id }}">
                @endif

                <!-- Company Name -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-building text-primary me-1"></i> Company Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-lg"
                           value="{{ old('name', $company->name) }}" placeholder="Enter company name" required>
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-envelope text-primary me-1"></i> Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control form-control-lg"
                           value="{{ old('email', $company->email) }}" placeholder="Enter email" required>
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-phone text-primary me-1"></i> Phone</label>
                    <input type="text" name="phone" class="form-control form-control-lg"
                           value="{{ old('phone', $company->phone) }}" placeholder="Enter phone number (optional)">
                    @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-map-marker-alt text-primary me-1"></i> Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control form-control-lg"
                           value="{{ old('address', $company->address) }}" placeholder="Enter address" required>
                    @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- city  -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-map-marker-alt text-primary me-1"></i> City <span class="text-danger">*</span></label>
                    <input type="text" name="city" class="form-control form-control-lg"
                           value="{{ old('city', $company->city) }}" placeholder="Enter city" required>
                    @error('city') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- state -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-map-marker-alt text-primary me-1"></i> State <span class="text-danger">*</span></label>
                    <input type="text" name="state" class="form-control form-control-lg"
                           value="{{ old('state', $company->state) }}" placeholder="Enter state" required>
                    @error('state') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- country -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-map-marker-alt text-primary me-1"></i> Country</label>
                    <input type="text" name="country" class="form-control form-control-lg"
                           value="{{ old('country', $company->country ?? 'India') }}" placeholder="Enter country">
                    @error('country') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- zip -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-map-marker-alt text-primary me-1"></i> Zip <span class="text-danger">*</span></label>
                    <input type="text" name="zip" class="form-control form-control-lg"
                           value="{{ old('zip', $company->zip) }}" placeholder="Enter zip" required>
                    @error('zip') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- owner name -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-building text-primary me-1"></i> Owner Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="owner_name" class="form-control form-control-lg"
                           value="{{ old('owner_name', $company->owner_name) }}" placeholder="Enter owner full name" required>
                    @error('owner_name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- owner email -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-envelope text-primary me-1"></i> Owner Email <span class="text-danger">*</span></label>
                    <input type="email" name="owner_email" class="form-control form-control-lg"
                           value="{{ old('owner_email', $company->owner_email) }}" placeholder="Enter owner email" required>
                    @error('owner_email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- owner mobile -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-phone text-primary me-1"></i> Owner Mobile <span class="text-danger">*</span></label>
                    <input type="text" name="owner_mobile" class="form-control form-control-lg"
                           value="{{ old('owner_mobile', $company->owner_mobile) }}" placeholder="Enter owner mobile" required>
                    @error('owner_mobile') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- owner designation -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-building text-primary me-1"></i>Designation</label>
                    <input type="text" name="owner_designation" class="form-control form-control-lg"
                           value="{{ old('owner_designation', $company->owner_designation) }}" placeholder="Enter designation (optional)">
                    @error('owner_designation') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- domain -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-globe text-primary me-1"></i> Domain</label>
                    <input type="text" name="domain" class="form-control form-control-lg"
                           value="{{ old('domain', $company->domain) }}" placeholder="Enter domain (optional)">
                    @error('domain') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-toggle-on text-primary me-1"></i> Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select form-select-lg">
                        <option value="1" {{ old('status', $company->status) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $company->status) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Logo Input Section -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-image text-primary me-1"></i> Logo</label>

                    <!-- File input field -->
                    <input type="file" name="logo" class="form-control form-control-lg" id="logoInput" placeholder="Upload logo (optional)" onchange="updateLogoPreview()">

                    <!-- Display selected file name -->
                    <div id="fileNameDisplay"></div>

                    <!-- Image preview -->
                    <div id="imagePreview">
                        @if($company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Preview" width="100">
                        @endif
                    </div>

                    @error('logo')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

               <!-- Plan -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-toggle-on text-primary me-1"></i> Plan
                    </label>
                    <select name="plan_id" class="form-select form-select-lg">
                        <option value="" {{ old('plan_id', $company->plan_id) == '' ? 'selected' : '' }}>Select Plan</option>
                        @foreach ($pricingPlans as $plan)
                            <option value="{{ $plan->id }}" {{ old('plan_id', $company->plan_id) == $plan->id ? 'selected' : '' }}>
                                {{ $plan->plan_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('plan_id') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Buttons -->
                <div class="col-12 d-flex justify-content-end gap-3 mt-4">
                    <button type="submit" class="btn btn-primary btn-md">
                        <i class="fas fa-save me-1"></i>
                        {{ $company->exists ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
<script>
    function updateLogoPreview() {
        const fileInput = document.getElementById('logoInput');
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const imagePreview = document.getElementById('imagePreview');

        const file = fileInput.files[0];
        if (file) {
            // Display the file name
            fileNameDisplay.innerHTML = `File Selected: ${file.name}`;

            // Display image preview
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview" width="100">`;
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        } else {
            // If no file is selected, reset preview
            fileNameDisplay.innerHTML = '';
            imagePreview.innerHTML = '';
        }
    }
</script>
