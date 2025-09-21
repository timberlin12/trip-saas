<?php

namespace App\DataTables;

use App\Models\admin\Company;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\DataTables\BaseDataTable;

class CompanyDataTable extends BaseDataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $datatables = datatables()->eloquent($query);

        // Checkbox
        $datatables->addColumn('check', function ($row) {
            return '<input type="checkbox" class="select-table-row"
                        id="datatable-row-' . $row->id . '"
                        name="datatable_ids[]"
                        value="' . $row->id . '"
                        onclick="dataTableRowCheck(' . $row->id . ')">';
        });

        $datatables->addIndexColumn();

        // Status
        $datatables->editColumn('status', function ($row) {
            return $row->status
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
        });

        // Plan (fetch plan_name from relationship)
        $datatables->addColumn('plan_id', function ($row) {
            return $row->pricingPlan
                ? '<span class="badge bg-info">' . ucfirst($row->pricingPlan->plan_name) . '</span>'
                : '<span class="badge bg-warning">Not Assigned</span>';
        });

        // Created At
        $datatables->editColumn('created_at', function ($row) {
            return $row->created_at
                ? \Carbon\Carbon::parse($row->created_at)->format('d M Y, h:i a')
                : '-';
        });

        // Action buttons
        $datatables->addColumn('action', function ($row) {
            return '
                <div class="d-flex flex-shrink-0">
                    <a href="' . route('companies.createOrEdit', $row->id) . '"
                        class="btn btn-icon btn-bg-light btn-active-color-success btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="javascript:;"
                        class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm ms-2 delete-company"
                        data-id="' . $row->id . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>';
        });

        $datatables->rawColumns(['action', 'check', 'status', 'plan_id']);

        return $datatables;
    }

    public function query(Company $model): QueryBuilder
    {
        $request = $this->request();
        $query = $model->newQuery();

        if ($request->search_text != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_text . '%')
                  ->orWhere('email', 'like', '%' . $request->search_text . '%')
                  ->orWhere('phone', 'like', '%' . $request->search_text . '%')
                  ->orWhere('owner_name', 'like', '%' . $request->search_text . '%')
                  ->orWhereHas('pricingPlan', function ($q) use ($request) {
                      $q->where('plan_name', 'like', '%' . $request->search_text . '%');
                  });
            });
        }

        if ($request->has('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('status', $status);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('companies-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(2)
            ->destroy(true)
            ->responsive(false)
            ->serverSide(true)
            ->stateSave(true)
            ->processing(true)
            ->dom($this->domHtml)
            ->language(['lengthMenu' => 'Show _MENU_ entries'])
            ->buttons(Button::make(['extend' => 'excel', 'text' => '<i class="fa fa-file-export"></i> Export']));
    }

    public function getColumns(): array
    {
        return [
            'check' => [
                'title' => '<input type="checkbox" name="select_all_table"
                            id="select-all-table"
                            onclick="selectAllTable(this)">',
                'exportable' => false,
                'orderable' => false,
                'searchable' => false
            ],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'visible' => false],
            'Id' => ['data' => 'id', 'name' => 'id', 'title' => 'ID', 'orderable' => true],
            'Name' => ['data' => 'name', 'name' => 'name', 'title' => 'Company Name'],
            'Email' => ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            'Phone' => ['data' => 'phone', 'name' => 'phone', 'titlse' => 'Phone'],
            'Owner' => ['data' => 'owner_name', 'name' => 'owner_name', 'title' => 'Owner Name'],
            'Plan' => ['data' => 'plan_id', 'name' => 'plan_id', 'title' => 'Plan'],
            'Status' => ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            'Created At' => ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],
            Column::computed('action', 'Action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-right pr-20')
        ];
    }

    protected function filename(): string
    {
        return 'Companies_' . date('YmdHis');
    }
}
