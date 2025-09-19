<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\File;

class BaseDataTable extends DataTable
{

    protected $company;
    public $user;
    public $domHtml;

    public function __construct()
    {
        // $this->user = user();
        // $this->domHtml = "<'row'<'col-sm-12'tr>><'d-flex align-items-center flex-column flex-md-row'<'flex-grow-1'l><i><p>>";
        $this->domHtml = '<"dt-top d-flex align-items-center mb-2" l>' .
            // ─────── TABLE ───────
            'rt' .
            // ───── BOTTOM ROW ─────
            '<"dt-bottom d-flex justify-content-between align-items-center flex-column flex-md-row" i p>';
    }

        public function setBuilder($table, $orderBy = 1)
    {

        return parent::builder()
            ->setTableId($table)
            ->columns($this->getColumns()) /** @phpstan-ignore-line */
            ->minifiedAjax()
            ->orderBy($orderBy)
            ->destroy(true)
            ->responsive()
            ->serverSide()
            ->stateSave(false)
            ->pageLength(10)
            ->processing()
            ->dom($this->domHtml);
    }

    // protected function filename()
    // {
    //     // Remove DataTable from name
    //     $filename = str()->snake(class_basename($this), '-');

    //     return str_replace('data-table', '', $filename)  . now()->format('Y-m-d-H-i-s');
    // }



}
