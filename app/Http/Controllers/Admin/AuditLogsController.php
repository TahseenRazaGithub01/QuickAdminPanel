<?php

namespace App\Http\Controllers\Admin;

use App\AuditLog;
use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AuditLogsController extends Controller
{
    public function index(Request $request)
    {
        abort_if((!getSiteID() > 0), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = AuditLog::query()->select(sprintf('%s.*', (new AuditLog)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'audit_log_show';
                $editGate      = 'audit_log_edit';
                $deleteGate    = 'audit_log_delete';
                $crudRoutePart = 'audit-logs';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('subject_id', function ($row) {
                return $row->subject_id ? $row->subject_id : "";
            });
            $table->editColumn('properties', function ($row) {
                if(!empty($row->properties['title'])){
                    return $row->properties['title'];
                }elseif(!empty($row->properties['name'])){
                    return $row->properties['name'];
                }else{
                    return "";
                }

            });
            $table->editColumn('subject_type', function ($row) {
                return $row->subject_type ? $row->subject_type : "";
            });

            $table->editColumn('user_id', function ($row) {
                $log = AuditLog::where('user_id', $row->user_id)->first();
                return isset($log->user->name) ? $log->user->name : "" ;
            });
            $table->editColumn('host', function ($row) {
                return $row->host ? $row->host : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.auditLogs.index');
    }

    public function show(AuditLog $auditLog)
    {
        abort_if(Gate::denies('audit_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        return view('admin.auditLogs.show', compact('auditLog'));
    }
}
