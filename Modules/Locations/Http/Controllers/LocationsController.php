<?php

namespace Modules\Locations\Http\Controllers;

use Modules\Locations\DataTables\LocationsDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Locations\Entities\Locations;
use Modules\Locations\Entities\UsersLocations;
use Modules\Product\Entities\ProductLocation;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;

class LocationsController extends Controller
{

  use ValidatesRequests;

    public function index(LocationsDataTable $dataTable) {
        $Alllocation = Locations::whereNull('parent_id')->get();
        abort_if(Gate::denies('access_locations'), 403);
        return $dataTable->render('locations::locations.index',compact('Alllocation'));
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
            // 'parent_id' => 'sometimes|nullable|numeric'
      ]);
      if(!empty($request->sub_location)) {
         $parent_id = $request->sub_location;
        } else {
         $parent_id = null;

        }
        // dd($input);
   Locations::create([
        'name' => $request->name,
        'parent_id' =>  $request->parent_id,
        'type' =>  $request->type,
        ]);

      //Locations::create($input);


      toast('Location Created!', 'success');
     return redirect()->route('locations.create');

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
            'name'  => 'required|min:3|max:255|string',
            'type'  => 'required'
        ]);
        $location->update($validatedData);

       toast('Location Updated!', 'info');

    return redirect()->route('locations.create');
}




    public function destroy(Locations $location) {
        abort_if(Gate::denies('delete_locations'), 403);
        $userloc = UsersLocations::where('id_location',$location->id)->orWhere('sub_location',$location->id)->first();
        if(!empty($userloc)){
            toast("Location can't be deleted cause foreign to user!", 'error');
    
            return redirect()->back(); 
        }
        
        $userprod = ProductLocation::where('location_id',$location->id)->first();
        if(!empty($userprod)){
            toast("Location can't be deleted cause foreign to product!", 'error');
    
            return redirect()->back(); 
        }
        

        $childs = $location->childs;
        if(count($location->childs)){
            foreach ($childs as $child1) {
                $child2 = $child1->childs;
                if(count($child1->childs)){
                    foreach ($child2 as $child2) {
                        $child3 = $child2->childs;
                        if(count($child2->childs)){
                            foreach ($child3 as $child3) {
                                $child3->delete();       
                            }
                        }
                        $child2->delete();       
                    }
                }
                $child1->delete();       
            }
        }

        $location->delete();

        toast('Location Deleted!', 'warning');

        return redirect()->route('locations.index');
    }

    public function getone($id){
        $location = Locations::find($id);
        return response()->json($location);
    }
}
