<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies  = Currency::paginate(10);

            $headers = [
                'name' => 'الاسم',
                'symbol' => 'الرمز',
                'is_foreign' => 'عملة محلية؟',
                'exchange_rate' => 'سعر الصرف'
            ];

            $route = 'admin.currencies';

            $buttons = [
                'add' => route('admin.currencies.create'),
                'back' => route('admin.dashboard'),
                'form' => route('admin.currencies.index')
            ];

            if (request()->keyword) {
                $keyword = request()->keyword;
                $currencies = Currency::where('name', 'like', '%' . $keyword . '%')->paginate(10);
            }

            foreach ($currencies as $currency) {
                $currency->is_foreign = $currency->getforeignBadge();
            }

        

            return view('admin.currencies.index', compact('currencies', 'headers', 'route', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $back = route('admin.currencies.index');

        return view('admin.currencies.create', compact('back'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formData = $request->validate([
           'name' => 'required',
           'symbol' => 'required',
           'is_foreign' => 'required',
           'exchange_rate' => 'required'
        ]);

        Currency::create($formData);

        return redirect()->route('admin.currencies.index')->with('success', 'تمت العملية بنجاح');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $currencies = Currency::findOrFail($id);
        $back = route('admin.currencies.index');
        return view('admin.currencies.edit', compact('currencies', 'back'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $formData = $request->validate([
            'name' => 'required',
            'symbol' => 'required',
            'is_foreign' => 'required',
            'exchange_rate' => 'required'
        ]);

        Currency::where('id', $id)->update($formData);

        return redirect()->route('admin.currencies.index')->with('success', 'تمت العملية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $currencies = Currency::findOrFail($id);
        $currencies->delete();

        return redirect()->route('admin.currencies.index')->with('success', 'تمت العملية بنجاح');
    }
}
