@extends('layouts.app')

@include('sections.datatable_css')

@section('toolbar')
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Companies</h1>

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
        <!--end::Page title-->

        <div class="d-flex align-items-center py-1">
            {{-- <button id="export-companies" class="btn btn-primary btn-sm ml-3" style="margin-right: 10px;">
                <i class="fa fa-file-excel"></i> {{ __('messages.export') }}
            </button> --}}
            <a href="{{ route('companies.createOrEdit') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add Company
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-fluid mt-5">
        <section style="margin-top: 2rem;">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search_text">Search</label>
                        <input type="text" class="form-control" id="search_text" placeholder="Search companies...">
                    </div>
                </div>
            </div>
        </section>

        <!--begin::Post-->
        <div class="d-flex flex-column w-table rounded mt-5 bg-white p-5 container-fluid">
            {!! $dataTable->table(['class' => 'table table-hover border-0 w-100 responsive_view_table', 'id' => 'companies-table']) !!}
        </div>
    </div>
    <!--end::Post-->
</div>
@endsection

@include('sections.datatable_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    // Filters
    $('#companies-table').on('preXhr.dt', function(e, settings, data) {
        data['search_text'] = $('#search_text').val();
    });

    const showTable = () => {
        window.LaravelDataTables["companies-table"].draw(true);
    }

    $('#search_text').on('change keyup', function() {
        showTable();
    });

    // DELETE COMPANY - centralized Swal
    $('#companies-table').on('click', '.delete-company', function () {
        const id = $(this).data('id');
        const url = "{{ route('companies.destroy', ':id') }}";
        const are_you_sure = "Are you sure?";
        const you_will_not_be_able_to_recover_the_deleted_record = "You will not be able to recover the deleted record!";
        const yes_delete_it = "Yes, delete it!";
        const cancel = "Cancel";

        // Call the centralized confirmDelete function from swal.js
        confirmDelete(id, url, function() {
            window.LaravelDataTables["companies-table"].ajax.reload(null, false);
        }, are_you_sure, you_will_not_be_able_to_recover_the_deleted_record, yes_delete_it,cancel);
    });

});
</script>
