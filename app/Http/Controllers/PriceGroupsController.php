<?php

namespace App\Http\Controllers;

use App\Models\PriceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PriceGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
            $price_groups = PriceGroup::paginate(10);

            $headers = [
                'name' => 'الاسم',
                'notes' => 'ملاحظات'
            ];

            $route = 'admin.price_groups';

            $buttons = [
                'add' => route('admin.price_groups.create'),
                'back' => route('admin.dashboard'),
                'form' => route('admin.price_groups.index')
            ];

            if (request()->keyword) {
                $keyword = request()->keyword;
                $price_groups = PriceGroup::where('name', 'like', '%' . $keyword . '%')->paginate(10);
            }


            return view('admin.price_groups.index', compact('price_groups', 'headers', 'route', 'buttons'));
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $back = route('admin.price_groups.index');

        return view('admin.price_groups.create', compact('back'));
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
        PriceGroup::create($formData);
        return redirect()->route('admin.price_groups.index')->with('success', 'تمت العملية بنجاح');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $price_groups = PriceGroup::findOrFail($id);
        $back = route('admin.price_groups.index');
        return view('admin.price_groups.edit', compact('price_groups', 'back'));
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
        $price_groups = PriceGroup::findOrFail($id);
        $price_groups->update($formData);
        return redirect()->route('admin.price_groups.index')->with('success', 'تمت العملية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $price_groups = PriceGroup::findOrFail($id);
        $price_groups->delete();
        return redirect()->route('admin.price_groups.index')->with('success', 'تمت العملية بنجاح');
    }
}
