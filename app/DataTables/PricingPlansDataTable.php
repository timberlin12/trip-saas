<?php

namespace App\DataTables;

use App\Models\admin\PricingPlans;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\DataTables\BaseDataTable;

class PricingPlansDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<PricingPlans> $query
     */
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

        // Columns formatting
        $datatables->editColumn('price', function ($row) {
            return $row->currency . ' ' . number_format($row->price, 2);
        });

        $datatables->editColumn('discount_value', function ($row) {
            if ($row->discount_type && $row->discount_value > 0) {
                return $row->discount_type === 'percentage'
                    ? $row->discount_value . '%'
                    : $row->currency . ' ' . number_format($row->discount_value, 2);
            }
            return '-';
        });

        $datatables->editColumn('status', function ($row) {
            return $row->status
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
        });

        $datatables->editColumn('is_popular', function ($row) {
            return $row->is_popular
                ? '<span class="badge bg-primary">Popular</span>'
                : '-';
        });

        $datatables->editColumn('created_at', function ($row) {
            return $row->created_at
                ? \Carbon\Carbon::parse($row->created_at)->format('d M Y, h:i a')
                : '-';
        });

        // Action buttons
        $datatables->addColumn('action', function ($row) {
            return '
                <div class="d-flex flex-shrink-0">
                    <a href="' . route('pricing-plans.createOrEdit', $row->id) . '"
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

        $datatables->rawColumns(['action','check','status','is_popular']);

        return $datatables;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PricingPlans $model): QueryBuilder
    {
        $request = $this->request();
        $query = $model->newQuery();

        // Search
        if ($request->search_text != '') {
            $query->where(function ($q) use ($request) {
                $q->where('plan_name', 'like', '%' . $request->search_text . '%')
                  ->orWhere('description', 'like', '%' . $request->search_text . '%');
            });
        }

        return $query;
    }

    /**
     * Build HTML
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pricing-plans-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(2) // sort by ID
            ->destroy(true)
            ->responsive(false)
            ->serverSide(true)
            ->stateSave(true)
            ->processing(true)
            ->dom($this->domHtml)
            ->language(['lengthMenu' => 'Show _MENU_ entries'])
            ->buttons(Button::make(['extend' => 'excel', 'text' => '<i class="fa fa-file-export"></i> Export']));
    }

    /**
     * Columns for DataTable
     */
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
            'Plan Name' => ['data' => 'plan_name', 'name' => 'plan_name', 'title' => 'Plan Name'],
            'Price' => ['data' => 'price', 'name' => 'price', 'title' => 'Price'],
            'Discount' => ['data' => 'discount_value', 'name' => 'discount_value', 'title' => 'Discount'],
            'Billing Cycle' => ['data' => 'billing_cycle', 'name' => 'billing_cycle', 'title' => 'Billing Cycle'],
            'Status' => ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            'Popular' => ['data' => 'is_popular', 'name' => 'is_popular', 'title' => 'Popular'],
            'Created At' => ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],
            Column::computed('action', 'Action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-right pr-20')
        ];
    }

    /**
     * Filename for export
     */
    protected function filename(): string
    {
        return 'PricingPlans_' . date('YmdHis');
    }
}
