<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\AuditRelationTraits;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    use AuditRelationTraits;

    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->adminService->getAdmins();

            return DataTables::eloquent($query)
                ->editColumn('email_verified_at', fn($admin) => "<span class='badge badge-soft {$admin->verify_color}'>{$admin->verify_label}</span>")
                ->editColumn('status', fn($admin) => "<span class='badge badge-soft {$admin->status_color}'>{$admin->status_label}</span>")
                ->editColumn('created_by', fn($admin) => $this->creater_name($admin))
                ->editColumn('created_at', fn($admin) => $admin->created_at_formatted)
                ->editColumn('action', fn($admin) => view('components.admin.action-buttons', ['menuItems' => $this->menuItems($admin)])->render())
                ->rawColumns(['created_at', 'status', 'email_verified_at', 'created_by', 'action'])
                ->make(true);
        }
        return view('backend.admin.admin-management.admin.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
            ],
            [
                'routeName' => '',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
            ],
              [
                'routeName' => '',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['admin-status']
            ],
            [
                'routeName' => '',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
            ]

        ];
    }
}
