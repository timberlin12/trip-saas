<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Page Vendors Javascript-->
<script src="{{ asset('js/custom/apps/customers/list/export.js') }}"></script>
<script src="{{ asset('js/custom/apps/customers/list/list.js') }}"></script>
<script src="{{ asset('js/custom/apps/customers/add.js') }}"></script>
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset('js/widgets.bundle.js') }}"></script>
<script src="{{ asset('js/custom/widgets.js') }}"></script>
<script src="{{ asset('js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ asset('js/custom/utilities/modals/create-app.js') }}"></script>
<script src="{{ asset('js/custom/utilities/modals/users-search.js') }}"></script>
<!--end::Page Custom Javascript-->
<script src="{{ asset('js/custom/authentication/sign-in/general.js') }}"></script>
{{-- custom js or jquery code for --}}
<script src="{{ asset('js/custom-ajax.js') }}"></script>
