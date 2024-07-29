<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Item;
use App\Models\ItemAttachment;
use App\Models\ItemPrice;
use App\Models\PriceGroup;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        try {
            $query = Item::with(['brand', 'createdByUser']);

            if (request()->keyword) {
                $query->where('name', 'like', '%' . request()->keyword . '%')->orWhere('code', 'like', '%' . request()->keyword . '%');
            }

            if (request()->filter == '1') {

                if (request()->brand_id) {
                    $query->where('brand_id', request()->brand_id);
                }

                if (request()->is_out_of_stock != 'all') {
                    $query->where('is_out_of_stock', request()->is_out_of_stock);
                }
            }

            $items = $query->paginate(10)->appends(request()->query());

            $headers = [
                'code' => 'الكود',
                'barcode' => 'الباركود',
                'name' => 'اسم المادة',
                'brand_name' => 'اسم الوكالة',
                'price' => 'السعر',
                'is_out_of_stock_status' => 'حالة المخزن',
                'is_visible_status' => 'حالة الظهور',
                'view_count' => 'عدد المشاهدات',
            ];

            $route = 'admin.items';
            $buttons = [
                'add' => route('admin.items.create'),
                'filter' => true,
                'back' => route('admin.dashboard'),
                'form' => route('admin.items.index')
            ];



            foreach ($items as $item) {
                $item->is_out_of_stock_status = $item->getIsOutOfStockBadge();
                $item->is_visible_status = $item->getIsVisibleBadge();
                $item->brand_name = $item->brand->name;
                $item->view_count = $item->views()->sum('view_count');
            }

            return view('admin.items.index', compact('items', 'headers', 'route', 'buttons'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



    public function create()
    {
        $back = route('admin.items.index');
        $price_groups = PriceGroup::all();

        return view('admin.items.create', compact('back', 'price_groups'));
    }




    public function store(Request $request)
    {

        $formData =  $request->validate([
            'brand_id' => 'required',
            'code' => 'required',
            'barcode' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'country_id' => 'required',
            'current_quantity' => 'required',
            'discount' => 'nullable',
            'price' => 'required',
            'is_out_of_stock' => 'required',
            'is_visible' => 'required',


        ], [
            'brand_id.required' => 'يرجى تحديد الوكالة',
            'code.required' => 'يرجى تحديد الكود',
            'barcode.required' => 'يرجى تحديد الباركود',
            'name.required' => 'يرجى تحديد الاسم',
            'current_quantity.required' => 'يرجى تحديد الكمية الحالية',
            'price.required' => 'يرجى تحديد السعر',
            'country_id.required' => 'يرجى تحديد البلد',
            'is_out_of_stock.required' => 'يرجى تحديد حالة المنتج في المخزون',
            'is_visible.required' => 'يرجى تحديد حالة الظهور للمنتج',


        ]);

        $item = Item::create($formData);


        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $key => $file) {
                $attachment = new ItemAttachment();
                $attachment->item_id = $item->id;

                $fileName = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

                // Move the file to the specified directory
                $file->move(public_path('uploads/items'), $fileName);

                $attachment->name = $fileName;
                $attachment->save();
            }
        }

        if ($request->input('price_groups')) {
            foreach ($request->input('price_groups') as $key => $value) {
                $item_price = new ItemPrice();
                $item_price->item_id = $item->id;
                $item_price->price_group_id = $key;
                $item_price->price = $value;
                $item_price->save();
            }
        }
        if ($request->input('item_categories')) {
            foreach ($request->input('item_categories') as $key => $value) {
                $item->categories()->attach($value);
            }
        }
        return redirect()->route('admin.items.index')->with('success', 'تم الحفظ بنجاح');
    }


    public function edit(string $id)
    {

        $item = Item::findOrFail($id);
        $back = route('admin.items.index');
        $price_groups = PriceGroup::all();
        return view('admin.items.edit', compact('item', 'back', 'price_groups'));
    }


    public function update(Request $request, string $id)
    {

        $formData =  $request->validate([
            'brand_id' => 'required',
            'code' => 'required',
            'barcode' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'country_id' => 'required',
            'current_quantity' => 'required',
            'price' => 'required',
            'discount' => 'nullable',
            'is_out_of_stock' => 'required',
            'is_visible' => 'required',


        ], [
            'brand_id.required' => 'يرجى تحديد الوكالة',
            'code.required' => 'يرجى تحديد الكود',
            'barcode.required' => 'يرجى تحديد الباركود',
            'name.required' => 'يرجى تحديد الاسم',
            'current_quantity.required' => 'يرجى تحديد الكمية الحالية',
            'price.required' => 'يرجى تحديد السعر',
            'country_id.required' => 'يرجى تحديد البلد',
            'is_out_of_stock.required' => 'يرجى تحديد حالة المنتج في المخزون',
            'is_visible.required' => 'يرجى تحديد حالة الظهور للمنتج',

        ]);
        $item = Item::findOrFail($id);
        $item->update($formData);


        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $key => $file) {
                $attachment = new ItemAttachment();
                $attachment->item_id = $item->id;

                $fileName = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

                // Move the file to the specified directory
                $file->move(public_path('uploads/items'), $fileName);

                $attachment->name = $fileName;
                $attachment->save();
            }
        }

        if ($request->input('price_groups')) {
            $item->prices()->delete();
            foreach ($request->input('price_groups') as $key => $value) {
                $item_price = new ItemPrice();
                $item_price->item_id = $item->id;
                $item_price->price_group_id = $key;
                $item_price->price = $value;
                $item_price->save();
            }
        }
        $item->categories()->detach();
        if ($request->input('item_categories')) {
            foreach ($request->input('item_categories') as $key => $value) {
                $item->categories()->attach($value);
            }
        }
        return redirect()->route('admin.items.index')->with('success', 'تم الحفظ بنجاح');
    }

    public function destroy(string $id)
    {

        $item = Item::findOrFail($id);

        // Delete associated attachments
        foreach ($item->attachments as $attachment) {
            $filePath = public_path('uploads/items/' . $attachment->name);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $attachment->delete();
        }

        // Delete associated prices
        $item->prices()->delete();

        // Detach categories
        $item->categories()->detach();

        // Delete the item
        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'تم الحذف بنجاح');
    }


    // public function export()
    // {
    //     return Excel::download(new ItemsExport(), 'items.xlsx');
    // }
    public function getLastChildCode(Request $request)
    {
        $brandId = $request->input('brand_id');
        $brand = Brand::findOrFail($brandId);

        if (!$brand) {
            return response()->json(['error' => 'brand not found'], 404);
        }

        $brandCode = $brand->code;
        $lastChild = Item::where('brand_id', $brandId)->orderBy('code', 'desc')->first();

        if ($lastChild) {
            $lastChildCode = substr($lastChild->code, strlen($brandCode));
            $newChildCode = str_pad((int)$lastChildCode + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newChildCode = '001';
        }

        $newCode = $brandCode . $newChildCode;

        return response()->json(['new_code' => $newCode]);
    }


    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls,csv',
    //     ], [
    //         'file.required' => 'يرجى تحميل الملف',
    //         'file.mimes' => 'نوع الملف غير مدعوم',
    //     ]);

    //     Excel::import(new ItemsImport, $request->file('file'));


    //     return redirect()->route('drugstore.items.index')->with('success', 'تم الاستيراد بنجاح');
    // }
    // public function importPrices(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls,csv',
    //     ], [
    //         'file.required' => 'يرجى تحميل الملف',
    //         'file.mimes' => 'نوع الملف غير مدعوم',
    //     ]);

    //     Excel::import(new ItemPricesImport, $request->file('file'));


    //     return redirect()->route('drugstore.items.index')->with('success', 'تم الاستيراد بنجاح');
    // }




    // public function AjaxSearch(Request $request)
    // {
    //     try {
    //         $query = $request->input('query');


    //         $items = Item::where('type', 'child')->where('trade_name', 'LIKE', "%{$query}%")
    //             ->orWhere('code', 'LIKE', "%{$query}%")
    //             ->get();

    //         return response()->json($items);
    //     } catch (\Exception $e) {

    //         return response()->json(['error' => 'Something went wrong'], 500);
    //     }
    // }
}
