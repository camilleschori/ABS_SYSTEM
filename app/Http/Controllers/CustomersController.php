<?php

namespace App\Http\Controllers;

use App\Models\PriceGroup;
use App\Models\Profile;
use App\Models\Region;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index()
    {

        $customers = Profile::with(['createdByUser'])->where('type', 'customer')->paginate(10);
        $headers = [
            'name' => 'اسم الزبون',
            'email' => 'البريد الالكتروني',
            'phone' => 'رقم الهاتف',
            'status_badge' => 'حالة الحساب',
            'created_at' => 'تاريخ الانشاء',
            'created_by_user_name' => 'انشئ بواسطة',

        ];
        $route = 'admin.customers';

        $buttons = [
            'add' => route('admin.customers.create'),
            'filter' => true,
            'back' => route('admin.dashboard'),
            'form' => route('admin.customers.index')
        ];

        if (request()->keyword) {
            $keyword = request()->keyword;
            $customers = Profile::where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhere('type', 'like', '%' . $keyword . '%')
                ->paginate(10);
        }
        foreach ($customers as $customer) {
            $customer->status_badge = $customer->getStatusBadge();
        }

        return view('admin.customers.index', compact('customers', 'headers', 'route', 'buttons'));
    }

    public function create()
    {

        $back = route('admin.customers.index');

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

        return view('admin.customers.create', compact('back', 'country_options', 'province_options', 'area_options', 'sub_area_options', 'price_group_options'));
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

            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

        ], [


            'phone' => 'رقم الهاتف أجباري',
            'status' => 'حالة الزبون أجباري',
            'name' => 'اسم الزبون أجباري',
            'country_id' => 'الدولة أجباري',
            'province_id' => 'المحافظة أجباري',


        ]);

        // Store the profile
        $customer = new Profile();
        $customer->type = 'customer';
        $customer->name = $validatedData['name'];
        $customer->phone = $validatedData['phone'];
        $customer->email = $validatedData['email'];
        $customer->address = $validatedData['address'];
        $customer->status = $validatedData['status'];

        $customer->country_id = $validatedData['country_id'];
        $customer->province_id = $validatedData['province_id'];
        $customer->area_id = $validatedData['area_id'];
        $customer->sub_area_id = $validatedData['sub_area_id'];
        $customer->price_group_id = $validatedData['price_group_id'];


        $customer->latitude = $validatedData['latitude'];
        $customer->longitude = $validatedData['longitude'];


        $customer->save();

        // Redirect back with success message
        return redirect()->route('admin.customers.index')->with('success', 'تمت الاضافة بنجاح.');
    }


    public function edit($id)
    {

        $customer = Profile::findOrFail($id);
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
        $back = route('admin.customers.index');
        return view('admin.customers.edit', compact('customer', 'back', 'country_options', 'province_options', 'area_options', 'sub_area_options', 'price_group_options'));
    }


    public function update(Request $request, $id)
    {
        try {
            $customer = Profile::findOrFail($id);
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
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ], [
                'phone' => 'رقم الهاتف أجباري',
                'status' => 'حالة الزبون أجباري',
                'name' => 'اسم الزبون أجباري',
                'country_id' => 'الدولة أجباري',
                'province_id' => 'المحافظة أجباري',

            ]);
            $customer->update($validatedData);
            return redirect()->route('admin.customers.index')->with('success', 'تم التعديل بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $customer = Profile::findOrFail($id);
            $customer->delete();
            return redirect()->route('admin.customers.index')->with('success', 'تم الحذف بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
