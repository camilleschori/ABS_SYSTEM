<?php

namespace App\Http\Controllers;

use App\Models\PriceGroup;
use App\Models\Profile;
use App\Models\Region;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function index()
    {

        $suppliers = Profile::with(['createdByUser'])->where('type', 'supplier')->paginate(10);
        $headers = [
            'name' => 'اسم المورد',
            'email' => 'البريد الالكتروني',
            'phone' => 'رقم الهاتف',
            'status_badge' => 'حالة الحساب',
            'created_at' => 'تاريخ الانشاء',
            'created_by_user_name' => 'انشئ بواسطة',

        ];
        $route = 'admin.suppliers';

        $buttons = [
            'add' => route('admin.suppliers.create'),
            'filter' => true,
            'back' => route('admin.dashboard'),
            'form' => route('admin.suppliers.index')
        ];

        if (request()->keyword) {
            $keyword = request()->keyword;
            $suppliers = Profile::where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhere('type', 'like', '%' . $keyword . '%')
                ->paginate(10);
        }
        foreach ($suppliers as $supplier) {
            $supplier->status_badge = $supplier->getStatusBadge();
        }

        return view('admin.suppliers.index', compact('suppliers', 'headers', 'route', 'buttons'));
    }

    public function create()
    {

        $back = route('admin.suppliers.index');

        $regions = Region::whereIn('type', ['country', 'province', 'area', 'sub_area'])->get();

        // Initialize empty arrays
        $country_options = [];
        $province_options = [];
        $area_options = [];
        $sub_area_options = [];

        // Iterate through the regions and categorize them
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
        $price_group_options = PriceGroup::pluck('name', 'id')->toArray();

        return view('admin.suppliers.create', compact('back', 'country_options', 'province_options', 'area_options', 'sub_area_options', 'price_group_options'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',

            'status' => 'required|string',

            'country_id' => 'required|exists:regions,id',
            'province_id' => 'required|exists:regions,id',
            'area_id' => 'nullable|exists:regions,id',
            'sub_area_id' => 'nullable|exists:regions,id',
            'price_group_id' => 'nullable|exists:price_groups,id',

        ], [


            'phone' => 'رقم الهاتف أجباري',
            'status' => 'حالة المورد أجباري',
            'name' => 'اسم المورد أجباري',
            'country_id' => 'الدولة أجباري',
            'province_id' => 'المحافظة أجباري',


        ]);

        // Store the profile
        $supplier = new Profile();
        $supplier->type = 'supplier';
        $supplier->name = $validatedData['name'];
        $supplier->phone = $validatedData['phone'];
        $supplier->email = $validatedData['email'];
        $supplier->address = $validatedData['address'];
        $supplier->status = $validatedData['status'];

        $supplier->country_id = $validatedData['country_id'];
        $supplier->province_id = $validatedData['province_id'];
        $supplier->area_id = $validatedData['area_id'];
        $supplier->sub_area_id = $validatedData['sub_area_id'];
        $supplier->price_group_id = $validatedData['price_group_id'];




        $supplier->save();

        // Redirect back with success message
        return redirect()->route('admin.suppliers.index')->with('success', 'تمت الاضافة بنجاح.');
    }


    public function edit($id)
    {

        $supplier = Profile::findOrFail($id);
        $regions = Region::whereIn('type', ['country', 'province', 'area', 'sub_area'])->get();
        $price_group_options = PriceGroup::pluck('name', 'id')->toArray();
        $country_options = [];
        $province_options = [];
        $area_options = [];
        $sub_area_options = [];
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
        $back = route('admin.suppliers.index');
        return view('admin.suppliers.edit', compact('supplier', 'back', 'country_options', 'province_options', 'area_options', 'sub_area_options', 'price_group_options'));
    }


    public function update(Request $request, $id)
    {
        try {
            $supplier = Profile::findOrFail($id);
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string|max:255',

                'status' => 'required|string',
                'country_id' => 'required|exists:regions,id',
                'province_id' => 'required|exists:regions,id',
                'area_id' => 'nullable|exists:regions,id',
                'sub_area_id' => 'nullable|exists:regions,id',
                'price_group_id' => 'nullable|exists:price_groups,id',

            ], [
                'phone' => 'رقم الهاتف أجباري',
                'status' => 'حالة المورد أجباري',
                'name' => 'اسم المورد أجباري',
                'country_id' => 'الدولة أجباري',
                'province_id' => 'المحافظة أجباري',

            ]);
            $supplier->update($validatedData);
            return redirect()->route('admin.suppliers.index')->with('success', 'تم التعديل بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $supplier = Profile::findOrFail($id);
            $supplier->delete();
            return redirect()->route('admin.suppliers.index')->with('success', 'تم الحذف بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
