<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Region;
use App\Models\Invoice;
use App\Models\Profile;
use App\Models\Currency;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function index()
    {
        $invoices = Invoice::WhereIn('type', ['sales', 'sales_return'])->paginate(10);

        $headers = [
            'number' => 'رقم الفاتورة',
            'formatted_type' => 'نوع الفاتورة',
            'date' => 'التاريخ',
            'customer_name' => 'اسم الزبون',
            'formatted_total_amount' => 'الاجمالي',
            'formatted_discount_value' => 'الخصم',
            'formatted_grand_total' => 'الصافي',
            'formatted_status' => 'حالة الفاتورة',

        ];
        $route = 'admin.sales';

        $buttons = [
            'add' => route('admin.sales.create'),
            'filter' => true,
            'back' => route('admin.dashboard'),
            'form' => route('admin.sales.index')
        ];

        if (request()->keyword) {
            $keyword = request()->keyword;
            $invoices = Invoice::WhereIn('type', ['sales', 'sales_return'])->where('number', 'like', '%' . $keyword . '%')
                ->paginate(10);
        }
        foreach ($invoices as $invoice) {
            $invoice->customer_name = $invoice->profile->name;
        }

        return view('admin.sales.index', compact('invoices', 'headers', 'route', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $back = route('admin.sales.index');
        $currencies = Currency::all();
        return view('admin.sales.create', compact('back', 'currencies'));
    }




    public function store(Request $request)
    {
        try {
            // Debug: Log the incoming request data
            Log::info('Incoming request data:', $request->all());
    
            // Get the last invoice number for the 'sales' type and increment it
            $lastInvoiceNumber = Invoice::where('type', 'sales')->max('number');
            $newInvoiceNumber = $lastInvoiceNumber ? $lastInvoiceNumber + 1 : 1;
    
            // Prepare the data for validation and adjust null values
            $data = $request->all();
    
            // Convert "null" string or empty values to actual null for optional fields
            $data['country_id'] = $data['country_id'] === 'null' || empty($data['country_id']) ? null : $data['country_id'];
            $data['province_id'] = $data['province_id'] === 'null' || empty($data['province_id']) ? null : $data['province_id'];
            $data['area_id'] = $data['area_id'] === 'null' || empty($data['area_id']) ? null : $data['area_id'];
            $data['sub_area_id'] = $data['sub_area_id'] === 'null' || empty($data['sub_area_id']) ? null : $data['sub_area_id'];
    
            // Debug: Log the data after processing null values
            Log::info('Processed data:', $data);
    
            // Validate request data
            $validatedData = Validator::make($data, [
                'date' => 'required|date',
                'type' => 'required|string|max:255',
                'profile_id' => 'required|exists:profiles,id',
                'currency_id' => 'required|exists:currencies,id',
                'exchange_rate' => 'required|numeric',
                'country_id' => 'nullable|exists:regions,id',
                'province_id' => 'nullable|exists:regions,id',
                'area_id' => 'nullable|exists:regions,id',
                'sub_area_id' => 'nullable|exists:regions,id',
                'address_title' => 'nullable|string|max:255',
                'address_phone' => 'nullable|string|max:255',
                'address_notes' => 'nullable|string|max:255',
                'total_amount' => 'required|numeric',
                'discount_percentage' => 'nullable|numeric',
                'discount_value' => 'nullable|numeric',
                'total_amount_after_discount' => 'required|numeric',
                'delivery_fees' => 'nullable|numeric',
                'grand_total' => 'required|numeric',
                'price_group_id' => 'required|exists:price_groups,id',
                'payment_method' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'notes' => 'nullable|string|max:255',
                'paid_amount' => 'nullable|numeric',
                'remaining_amount' => 'nullable|numeric',
                'payment_status' => 'required|string|max:255',
                'item_id.*' => 'required|exists:items,id',
                'item_price.*' => 'required|numeric',
                'item_quantity.*' => 'required|numeric',
                'item_total_before_discount.*' => 'required|numeric',
                'item_discount_percentage.*' => 'nullable|numeric',
                'item_discount_value.*' => 'nullable|numeric',
                'item_grand_total.*' => 'required|numeric',
                'item_notes.*' => 'nullable|string|max:255',
                'warehouse_id.*' => 'nullable|exists:warehouses,id',
            ])->validate();
    
            // Create new invoice
            $invoice = Invoice::create([
                'number' => $newInvoiceNumber,
                'date' => $validatedData['date'],
                'type' => $validatedData['type'],
                'profile_id' => $validatedData['profile_id'],
                'currency_id' => $validatedData['currency_id'],
                'exchange_rate' => $validatedData['exchange_rate'],
                'country_id' => $validatedData['country_id'],
                'province_id' => $validatedData['province_id'],
                'area_id' => $validatedData['area_id'],
                'sub_area_id' => $validatedData['sub_area_id'],
                'address_title' => $validatedData['address_title'],
                'address_phone' => $validatedData['address_phone'],
                'address_notes' => $validatedData['address_notes'],
                'total_amount' => $validatedData['total_amount'],
                'discount_percentage' => $validatedData['discount_percentage'],
                'discount_value' => $validatedData['discount_value'],
                'total_amount_after_discount' => $validatedData['total_amount_after_discount'],
                'delivery_fees' => $validatedData['delivery_fees'],
                'grand_total' => $validatedData['grand_total'],
                'price_group_id' => $validatedData['price_group_id'],
                'payment_method' => $validatedData['payment_method'],
                'status' => $validatedData['status'],
                'notes' => $validatedData['notes'],
                'stock_effection' => 1,
                'effection_type' => 'out',
                'paid_amount' => $validatedData['paid_amount'],
                'remaining_amount' => $validatedData['remaining_amount'],
                'payment_status' => $validatedData['payment_status'],
                'created_by' => auth()->user()->id,
                
            ]);
    
            // Add items to the invoice
            foreach ($validatedData['item_id'] as $index => $itemId) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $itemId,
                    'item_price' => $validatedData['item_price'][$index],
                    'item_quantity' => $validatedData['item_quantity'][$index],
                    'total_before_discount' => $validatedData['item_total_before_discount'][$index],
                    'discount_percentage' => $validatedData['item_discount_percentage'][$index],
                    'discount_value' => $validatedData['item_discount_value'][$index],
                    'grand_total' => $validatedData['item_grand_total'][$index],
                    'notes' => $validatedData['item_notes'][$index],
                    'warehouse_id' => $validatedData['warehouse_id'][$index],
                ]);
            }
    
            return redirect()->route('admin.sales.index')->with('success', 'Invoice created successfully.');
    
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error creating invoice:', ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
    


    public function edit(string $id)
    {
        $invoice = Invoice::FindOrFail($id);
        $invoice_items = InvoiceItem::where('invoice_id', $id)->get();
        $currencies = Currency::all();
        $back = route('admin.sales.index');

        $country_options = [];
        $province_options = [];
        $area_options = [];
        $sub_area_options = [];
        $regions = Region::whereIn('type', ['country', 'province', 'area', 'sub_area'])->get();
        
        foreach ($regions as $region) {
            switch ($region->type) {
                case 'country':
                    $country_options[$region->id] = $region->name;
                    break;
                case 'province':
                    $province_options[$region->id] = $region->name;
                    break;
                case 'area':
                    $area_options[$region->id] = $region->name;
                    break;
                case 'sub_area':
                    $sub_area_options[$region->id] = $region->name;
                    break;
            }
        }


        return view('admin.sales.edit', compact('invoice', 'invoice_items' , 'back' , 'currencies' , 'country_options' , 'province_options' , 'area_options' , 'sub_area_options' ));
    }

    public function update(Request $request, $id)
    {
        try {
            // Debug: Log the incoming request data
            Log::info('Incoming request data:', $request->all());
    
            // Retrieve the existing invoice by ID
            $invoice = Invoice::findOrFail($id);
    
            // Prepare the data for validation and adjust null values
            $data = $request->all();
    
            // Convert "null" string or empty values to actual null for optional fields
            $data['country_id'] = $data['country_id'] === 'null' || empty($data['country_id']) ? null : $data['country_id'];
            $data['province_id'] = $data['province_id'] === 'null' || empty($data['province_id']) ? null : $data['province_id'];
            $data['area_id'] = $data['area_id'] === 'null' || empty($data['area_id']) ? null : $data['area_id'];
            $data['sub_area_id'] = $data['sub_area_id'] === 'null' || empty($data['sub_area_id']) ? null : $data['sub_area_id'];
    
            // Debug: Log the data after processing null values
            Log::info('Processed data:', $data);
    
            // Validate request data
            $validatedData = Validator::make($data, [
                'date' => 'required|date',
                'type' => 'required|string|max:255',
                'profile_id' => 'required|exists:profiles,id',
                'currency_id' => 'required|exists:currencies,id',
                'exchange_rate' => 'required|numeric',
                'country_id' => 'nullable|exists:regions,id',
                'province_id' => 'nullable|exists:regions,id',
                'area_id' => 'nullable|exists:regions,id',
                'sub_area_id' => 'nullable|exists:regions,id',
                'address_title' => 'nullable|string|max:255',
                'address_phone' => 'nullable|string|max:255',
                'address_notes' => 'nullable|string|max:255',
                'total_amount' => 'required|numeric',
                'discount_percentage' => 'nullable|numeric',
                'discount_value' => 'nullable|numeric',
                'total_amount_after_discount' => 'required|numeric',
                'delivery_fees' => 'nullable|numeric',
                'grand_total' => 'required|numeric',
                'price_group_id' => 'required|exists:price_groups,id',
                'payment_method' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'notes' => 'nullable|string|max:255',
                'paid_amount' => 'nullable|numeric',
                'remaining_amount' => 'nullable|numeric',
                'payment_status' => 'required|string|max:255',
                'item_id.*' => 'required|exists:items,id',
                'item_price.*' => 'required|numeric',
                'item_quantity.*' => 'required|numeric',
                'item_total_before_discount.*' => 'required|numeric',
                'item_discount_percentage.*' => 'nullable|numeric',
                'item_discount_value.*' => 'nullable|numeric',
                'item_grand_total.*' => 'required|numeric',
                'item_notes.*' => 'nullable|string|max:255',
                'warehouse_id.*' => 'nullable|exists:warehouses,id',
            ])->validate();
    
            // Update the invoice
            $invoice->update([
                'date' => $validatedData['date'],
                'type' => $validatedData['type'],
                'profile_id' => $validatedData['profile_id'],
                'currency_id' => $validatedData['currency_id'],
                'exchange_rate' => $validatedData['exchange_rate'],
                'country_id' => $validatedData['country_id'],
                'province_id' => $validatedData['province_id'],
                'area_id' => $validatedData['area_id'],
                'sub_area_id' => $validatedData['sub_area_id'],
                'address_title' => $validatedData['address_title'],
                'address_phone' => $validatedData['address_phone'],
                'address_notes' => $validatedData['address_notes'],
                'total_amount' => $validatedData['total_amount'],
                'discount_percentage' => $validatedData['discount_percentage'],
                'discount_value' => $validatedData['discount_value'],
                'total_amount_after_discount' => $validatedData['total_amount_after_discount'],
                'delivery_fees' => $validatedData['delivery_fees'],
                'grand_total' => $validatedData['grand_total'],
                'payment_method' => $validatedData['payment_method'],
                'status' => $validatedData['status'],
                'notes' => $validatedData['notes'],
                'paid_amount' => $validatedData['paid_amount'],
                'remaining_amount' => $validatedData['remaining_amount'],
                'payment_status' => $validatedData['payment_status'],
            ]);
    
            // Remove existing invoice items
            $invoice->items()->delete();
    
            // Add updated items to the invoice
            foreach ($validatedData['item_id'] as $index => $itemId) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $itemId,
                    'item_price' => $validatedData['item_price'][$index],
                    'item_quantity' => $validatedData['item_quantity'][$index],
                    'total_before_discount' => $validatedData['item_total_before_discount'][$index],
                    'discount_percentage' => $validatedData['item_discount_percentage'][$index],
                    'discount_value' => $validatedData['item_discount_value'][$index],
                    'grand_total' => $validatedData['item_grand_total'][$index],
                    'notes' => $validatedData['item_notes'][$index],
                    'warehouse_id' => $validatedData['warehouse_id'][$index],
                ]);
            }
    
            return redirect()->route('admin.sales.index')->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error updating invoice:', ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
    


    public function destroy(string $id)
    {
        $invoice = Invoice::FindOrFail($id);
        
        $invoice_items = InvoiceItem::where('invoice_id', $id)->get();
        foreach ($invoice_items as $item) {
            $item->delete();
        }
        $invoice->delete();
        return redirect()->route('admin.sales.index')->with('success', 'تمت العملية بنجاح');
    }



    public function SearchCustomer(Request $request)
    {
        try {
            $query = $request->input('query');

            $profiles = Profile::where('type', 'customer')
                ->where('name', 'LIKE', "%{$query}%")
                ->with(['country', 'province', 'area', 'subArea']) // Include related region data
                ->get();

            return response()->json($profiles);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }


    public function SearchItems(Request $request)
    {
        try {
            $query = $request->input('query');

            $items = Item::where('name', 'LIKE', "%{$query}%")
                ->with('prices') // Assuming `prices` relationship returns all price groups
                ->get();

            $response = $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'prices' => $item->prices->pluck('price', 'price_group_id') // Returns {price_group_id: price}
                ];
            });

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }


    public function print(string $id){

        $invoice = Invoice::FindOrFail($id);
        $invoice_items = InvoiceItem::where('invoice_id', $id)->get();

        return view('admin.sales.print', compact('invoice' ,'invoice_items'));
    }
}
