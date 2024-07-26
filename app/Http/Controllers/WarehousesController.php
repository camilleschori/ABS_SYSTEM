<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehousesController extends Controller
{
    public function index()
    {
       
            $warehouses = Warehouse::paginate(10);

            $headers = [
                'name' => 'الاسم',
            ];

            $route = 'admin.warehouses';

            $buttons = [
                'add' => route('admin.warehouses.create'),
                'back' => route('admin.dashboard'),
                'form' => route('admin.warehouses.index')
            ];

            if (request()->keyword) {
                $keyword = request()->keyword;
                $warehouses = Warehouse::where('name', 'like', '%' . $keyword . '%')->paginate(10);
            }


            return view('admin.warehouses.index', compact('warehouses', 'headers', 'route', 'buttons'));
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $back = route('admin.warehouses.index');

        return view('admin.warehouses.create', compact('back'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formData = $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'يجب ادخال الاسم'
        ]);
        Warehouse::create($formData);
        return redirect()->route('admin.warehouses.index')->with('success', 'تمت العملية بنجاح');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $warehouses = Warehouse::findOrFail($id);
        $back = route('admin.warehouses.index');
        return view('admin.warehouses.edit', compact('warehouses', 'back'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $formData = $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'يجب ادخال الاسم'
        ]);
        $warehouses = Warehouse::findOrFail($id);
        $warehouses->update($formData);
        return redirect()->route('admin.warehouses.index')->with('success', 'تمت العملية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warehouses = Warehouse::findOrFail($id);
        $warehouses->delete();
        return redirect()->route('admin.warehouses.index')->with('success', 'تمت العملية بنجاح');
    }
}
