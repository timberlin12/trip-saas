<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<!-- Scripts -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>



<!-- Datatables -->
<!-- <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
{{-- <script src="{{ asset('vendor/datatables/dataTables.responsive.min.js') }}"></script> --}}
{{-- <script src="{{ asset('vendor/datatables/responsive.bootstrap.min.js') }}"></script> --}}
<script src="{{ asset('vendor/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script> -->

@if(isset($dataTable))
{!! $dataTable->scripts() !!}
@endif


<script type="text/javascript">
	// Files list view data tables reusable code

	// $(document).ready( function () {  create_data_table(); } );

	// function create_data_table(id = 'manage_files', search_field = 'searchbox') {
	// 	if (document.getElementById(id)) {
	// 	    var dataTable = $('#'+id).DataTable();
	// 	    $(document).on("keyup search input paste cut", "#"+search_field, function() {
	// 	        dataTable.search(this.value).draw();
	// 	    });
	//     } else {
	// 		console.error('Error: provided id '+id+' is not exists. From dataTables_js.blade.php');
	//     }
	// }

function create_data_table_with_ajax_search(url, id = 'search_manage_files', search_field = 'searchbox')
{
    if (!document.getElementById(id)) {
		console.error('Error: provided id ' + id + ' does not exist. From dataTables_js.blade.php');
		return;
    }

    var columns = [
            { data: 'name' },
            { data: 'type' },
            { data: 'size' },
            { data: 'createdOn' },
            { data: 'action' }
        ];

    // Add checkbox column only to projects
    if(url.includes('projects'))
    {
        columns.splice(0, 0, { data: 'checkbox', orderable: false, searchable: false, width:'15px' });
    }

    if (url.includes('document')) {

        columns.splice(0, 0, { data: 'checkbox', orderable: false, searchable: false, width:'15px' });
        columns.splice(2, 0, { data: 'path' });
        columns.splice(5, 0, { data: 'assignTo' });
    }

    if (url.includes('property')) {

        columns.splice(0, 0, { data: 'checkbox', orderable: false, searchable: false, width:'15px' });
        columns.splice(2, 0, { data: 'path' });
    }

    var dataTable = $('#'+id).DataTable({
        pageLength: 50,
        ajax: {
            url: url,
            dataSrc: ''
        },
        columns: columns
    });

    if (url.includes('projects') || url.includes('document') || url.includes('property'))
    {
        dataTable.on('init', function () {
            $('#'+id+' thead th.sorting_asc').removeClass('sorting sorting_asc sorting_desc');
        });
    }


    let timeout = null;

    let previousRequest;

    $(document).on("keyup search paste", "#"+search_field, function()
    {
        var searchTerm = this.value;

        dataTable.search(searchTerm).draw();

        // Check if search term is found in the current data
        var filteredData = dataTable.rows({ search: 'applied' }).data();

        clearTimeout(timeout);

        // Make a new timeout set to go off in 1000ms (1 second)
        timeout = setTimeout(function () {

            if (previousRequest) {
                previousRequest.abort();
            }

            $('#'+id+'_wrapper').block({ message: 'Please Wait...'});

            // Ajax call to search in db
           previousRequest =  $.ajax({
                url: url,
                method: 'GET',
                data: { search: searchTerm },
                success: function(response)
                {
                    dataTable.clear();
                    dataTable.rows.add(response);
                    dataTable.draw();
                    $('#'+id+'_wrapper').unblock();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    if (textStatus !== 'abort') {
                      console.log('Error:', errorThrown);
                    } else {
                      console.log('Request aborted');
                    }
                }
            });
        }, 1000);
    });


}


const selectAllTable = (source) => {
    checkboxes = document.getElementsByName("datatable_ids[]");
    for (var i = 0, n = checkboxes.length; i < n; i++) {

        if (!$("#" + checkboxes[i].id).prop('disabled')){
            checkboxes[i].checked = source.checked;
        }
        if ($("#" + checkboxes[i].id).is(":checked")) {
            $("#" + checkboxes[i].id)
                .closest("tr")
                .addClass("table-active");
        } else {
            $("#" + checkboxes[i].id)
                .closest("tr")
                .removeClass("table-active");
        }
    }

};


const dataTableRowCheck = (id) => {
    if ($(".select-table-row:checked").length > 0) {
        document.getElementById("select-all-table").indeterminate = true;
    } else {
        document.getElementById("select-all-table").indeterminate = false;
        $("#select-all-table").attr("checked", false);
    }

    if ($("#datatable-row-" + id).is(":checked")) {
        $("#row-" + id).addClass("table-active");
    } else {
        $("#row-" + id).removeClass("table-active");
    }
};


</script>
