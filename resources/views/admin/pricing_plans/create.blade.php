@extends('layouts.app')

@section('toolbar')
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">
                {{ $pricingPlan->exists ? 'Edit Pricing Plan' : 'Add New Pricing Plan' }}
            </h1>
            <span class="h-20px border-gray-300 border-start mx-4"></span>
            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-300 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-dark">Pricing Plans</li>
            </ul>
        </div>
        <div class="d-flex align-items-center py-1">
            <a href="{{ route('pricing-plans.index') }}" class="btn btn-secondary btn-sm">
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

            <form method="POST" action="{{ route('pricing-plans.storeOrUpdate') }}" class="row g-4">

                @csrf
                @if($pricingPlan->exists)
                    <input type="hidden" name="id" value="{{ $pricingPlan->id }}">
                @endif

                <!-- Plan Name -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-tag text-primary me-1"></i>Plan Name</label>
                    <input type="text" name="plan_name" class="form-control form-control-lg"
                           value="{{ old('plan_name', $pricingPlan->plan_name) }}" placeholder="Enter plan name" >
                    @error('plan_name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Price -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-dollar-sign text-primary me-1"></i>Price (INR)</label>
                    <input type="number" step="0.01" name="price" class="form-control form-control-lg"
                           value="{{ old('price', $pricingPlan->price) }}" placeholder="Enter price" >
                    @error('price') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Billing Cycle -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-coins text-primary me-1"></i>Billing Cycle</label>
                    <select name="billing_cycle" class="form-select form-select-lg" >
                        <option value="monthly" {{ old('billing_cycle', $pricingPlan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ old('billing_cycle', $pricingPlan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        <option value="lifetime" {{ old('billing_cycle', $pricingPlan->billing_cycle) == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                    </select>
                </div>

                <!-- Trial Days -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt text-primary me-1"></i>Trial Days</label>
                    <input type="number" name="trial_days" class="form-control form-control-lg"
                           value="{{ old('trial_days', $pricingPlan->trial_days) }}" placeholder="Enter trial days">
                </div>

                <!-- Max Users -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-users text-primary me-1"></i>Max Users</label>
                    <input type="number" name="max_users" class="form-control form-control-lg"
                           value="{{ old('max_users', $pricingPlan->max_users) }}" placeholder="Enter max users">
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-toggle-on text-primary me-1"></i>Status</label>
                    <select name="status" class="form-select form-select-lg">
                        <option value="1" {{ old('status', $pricingPlan->status) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $pricingPlan->status) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Features -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-list text-primary me-1"></i> Features
                    </label>

                    <div id="features-wrapper">
                        @if(is_array($pricingPlan->features) && count($pricingPlan->features))
                            @foreach($pricingPlan->features as $feature)
                                <div class="d-flex mb-2 feature-item">
                                    <input type="text" name="features[]" class="form-control"
                                        value="{{ $feature }}" placeholder="Enter feature (e.g. Unlimited projects)">
                                    <button type="button" class="btn btn-danger ms-2 remove-feature">-</button>
                                </div>
                            @endforeach
                        @else
                        <div class="d-flex mb-2 feature-item">
                            <input type="text" name="features[]" class="form-control"
                            placeholder="Enter feature (e.g. Unlimited projects)">
                            <button type="button" class="btn btn-danger ms-2 remove-feature">-</button>
                        </div>
                        @endif
                    </div>

                    <button type="button" id="add-feature" class="btn btn-primary btn-sm mt-2">+ Add Feature</button>

                    @error('features')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-info-circle text-primary me-1"></i>Description</label>
                    <textarea name="description" rows="3" class="form-control" placeholder="Enter description">{{ old('description', $pricingPlan->description) }}</textarea>
                </div>


                <!-- Discount Type -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-percent text-primary me-1"></i> Discount Type
                    </label>
                    <select name="discount_type" class="form-select form-select-lg">
                        <option value="" selected>-- None --</option>
                        <option value="percentage" {{ old('discount_type', $pricingPlan->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" {{ old('discount_type', $pricingPlan->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                    </select>
                    @error('discount_type') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Discount Value -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-tag text-danger me-1"></i> Discount Value
                    </label>
                    <input type="number" step="0.01" name="discount_value" class="form-control form-control-lg"
                           value="{{ old('discount_value', $pricingPlan->discount_value) }}" placeholder="Enter discount value">
                    @error('discount_value') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <!-- Buttons -->
                <div class="col-12 d-flex justify-content-end gap-3 mt-4">
                    <button type="submit" class="btn btn-primary btn-md">
                        <i class="fas fa-save me-1"></i>
                        {{ $pricingPlan->exists ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('features-wrapper');
    const addBtn = document.getElementById('add-feature');

    // Add feature
    addBtn.addEventListener('click', function () {
        const div = document.createElement('div');
        div.classList.add('d-flex', 'mb-2', 'feature-item');
        div.innerHTML = `
            <input type="text" name="features[]" class="form-control"
                   placeholder="Enter feature (e.g. Unlimited projects)">
            <button type="button" class="btn btn-danger ms-2 remove-feature">-</button>
        `;
        wrapper.appendChild(div);
    });

    // Remove feature
    wrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-feature')) {
            e.target.closest('.feature-item').remove();
        }
    });
});

</script>
