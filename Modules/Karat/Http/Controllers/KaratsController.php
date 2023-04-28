<?php

namespace Modules\Karat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class KaratsController extends Controller
{



  public function __construct()
    {
        // Page Title
        $this->module_title = 'Karat';
        // module name
        $this->module_name = 'karat';
        // directory path of the module
        $this->module_path = 'karat';
        // module icon
        $this->module_icon = 'fas fa-sitemap';
        // module model name, path
        $this->module_model = "Modules\Karat\Models\Karat";


    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index() {
        abort_if(Gate::denies('access_karat'), 403);

         $module_action = 'List';
        
         return view('karat::karats.index', compact('module_action'));

    }




public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                         
                           ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);
                            if ($diff < 25) {
                                return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                            } else {
                                return \Carbon\Carbon::parse($data->created_at)->isoFormat('L');
                            }
                        })
                        ->rawColumns(['updated_at', 'action'])
                        ->make(true);
    }







    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
         $module_action = 'Create';
         return view('karat::karats.create', compact('module_action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
         $module_action = 'Show';
         return view('karat::karats.show', compact('module_action'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $module_action = 'Edit';
         return view('karat::karats.edit', compact('module_action'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
