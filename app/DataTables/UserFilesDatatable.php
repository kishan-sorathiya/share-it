<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\UserFiles;
use Yajra\DataTables\Services\DataTable;

class UserFilesDatatable extends DataTable {

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax() {
        return datatables()
                ->eloquent($this->query())
                ->addColumn('action', function ($row) {
                    return $this->checkrights($row);
                })
                ->make(true);
    }

    public function checkrights($row) {
        $deleteurl = route('userfiles.destroy', ['id' => $row->id]);

        $menu ='<td class="text-center">
                    <ul class="icons-list">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="' . $deleteurl . '">Share</a></li>
                            <li><a href="' . $deleteurl . '">Delete</a></li>
                            </ul></li></ul></td>';
        return $menu;
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query() {
        $models = UserFiles::select();

        if (request()->get('filename', false)) {
            $models->where('filename', 'like', "%" . request()->get("filename") . "%");
        }
        return $this->applyScopes($models);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() {
        return $this->builder()
                        ->parameters(['searching' => false])
                        ->columns($this->getColumns())
                        ->ajax('');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns() {
        return [
            ['name' => 'filename', 'data' => 'filename', 'title' => trans("comman.filename")],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans("comman.created_at")],
            ['name' => 'download', 'data' => 'download', 'title' => trans("comman.download")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => true, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return 'User Files';
    }

}
