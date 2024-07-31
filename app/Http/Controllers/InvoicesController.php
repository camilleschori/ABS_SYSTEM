<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Profile;
use App\Models\Currency;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::paginate(20);
        $headers = [
            'number' => 'رقم الفاتورة',
            'type' => 'نوع الفاتورة',
            'date' => 'التاريخ',
            'customer_name' => 'اسم الزبون',
            'total_amount' => 'الاجمالي',
            'discount_value' => 'الخصم',
            'grand_total' => 'الصافي',
            'status' => 'حالة الفاتورة',

        ];
        $route = 'admin.invoices';

        $buttons = [
            'add' => route('admin.invoices.create'),
            'filter' => true,
            'back' => route('admin.dashboard'),
            'form' => route('admin.invoices.index')
        ];

        if (request()->keyword) {
            $keyword = request()->keyword;
            $invoices = Invoice::where('number', 'like', '%' . $keyword . '%')
                ->paginate(10);
        }
        foreach ($invoices as $invoice) {
            $invoice->customer_name = $invoice->profile->name;
        }

        return view('admin.invoices.index', compact('invoices', 'headers', 'route', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $back = route('admin.invoices.index');
        $currencies = Currency::all();
        return view('admin.invoices.create', compact('back' , 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    
    public function AjaxSearch(Request $request)
    {
        try {
            $query = $request->input('query');
    
            $profiles = Profile::where('name', 'LIKE', "%{$query}%")->get();
    
            return response()->json($profiles);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
