<?php

namespace Modules\Locations\Http\Controllers;

use Modules\Locations\DataTables\LocationsDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Locations\Entities\Locations;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;

class LocationsController extends Controller
{

  use ValidatesRequests;

    public function index(LocationsDataTable $dataTable) {
        abort_if(Gate::denies('access_locations'), 403);
        return $dataTable->render('locations::locations.index');
    }


    public function create() {
        abort_if(Gate::denies('create_locations'), 403);


    $locations = Locations::with('childs')->whereNull('parent_id')->get();
    $subcategories = DB::table('locations')
        ->orderBy('name', 'asc')
        ->select('name','level','id','parent_id')
        ->get();

         return View('locations::locations.create')->with(compact('subcategories','locations'));
    }











public function getParent($parent=0){

         try {
            $result['data'] = Locations::orderby("name","asc")
                    ->select('id','name')
                    ->where('parent_id',$parent)
                    ->get();
                    return response()->json($result);
           }
               catch (\Exception $e)
                {  return response()->json([
                        'message' => $e->getMessage(),
                    ]);
                }

            }





public function store(Request $request)
{
     abort_if(Gate::denies('create_locations'), 403);

     $this->validate($request, [
            'name'      => 'required|min:3|max:255|string',
            'parent_id' => 'sometimes|nullable|numeric'
      ]);
      if(!empty($request->sub_location)) {
         $parent_id = $request->sub_location;
        } else {
         $parent_id = null;

        }
        // dd($input);
   Locations::create([
        'name' => $request->name,
        'parent_id' =>  $parent_id,
        ]);

      //Locations::create($input);


      toast('Location Created!', 'success');
     return redirect()->route('locations.index');

}

    public function show(Locations $location) {
        abort_if(Gate::denies('show_locations'), 403);

        return view('locations::locations.show', compact('location'));
    }


    public function edit(Locations $location) {
        abort_if(Gate::denies('edit_locations'), 403);

       $locations = Locations::with('childs')->whereNull('parent_id')->get();
       $subcategories = DB::table('locations')
        ->orderBy('name', 'asc')
        ->select('name','level','id','parent_id')
        ->get();


         return View('locations::locations.create')->with(compact('subcategories','locations'));
    }


public function update(Request $request,  Locations $location)
{
     abort_if(Gate::denies('update_locations'), 403);

     $validatedData = $this->validate($request, [
            'name'  => 'required|min:3|max:255|string'
        ]);
        $location->update($validatedData);

       toast('Location Updated!', 'info');

    return redirect()->route('locations.index');
}




    public function destroy(Locations $location) {
        abort_if(Gate::denies('delete_locations'), 403);

        $location->delete();

        toast('Location Deleted!', 'warning');

        return redirect()->route('locations.index');
    }
}
