<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionsController extends Controller
{
    public function index()
    {
        $regions = Region::with(['createdByUser'])->paginate(10);

        if (request()->filter && request()->type != 'all') {
            $regions = Region::with(['createdByUser'])->where('type', request()->type)->get();
        }

        if (request()->keyword) {
            $regions = Region::with(['createdByUser'])->where('name', 'like', '%' . request()->keyword . '%')->paginate(10);
        }

        $headers = [
            'name' => 'اسم المنطقة',
            'type_badge' => 'نوع المنطقة',
            'created_at' => 'تاريخ الانشاء',
            'created_by_user_name' => 'انشئ بواسطة',
        ];

        $route = 'admin.regions';

        $buttons = [
            'add' => route('admin.regions.create'),
            'filter' => true,
            'back' => route('admin.dashboard'),
            'form' => route('admin.regions.index')
        ];

        $type_options = [
            'all' => 'كل المناطق',
            'country' => 'دولة',
            'province' => 'محافظة',
            'area' => 'منطقة',
            'sub_area' => 'منطقة فرعية',
        ];

        // Define the type and badge color mapping
        $type_mapping = [
            'country' => 'دولة',
            'province' => 'محافظة',
            'area' => 'منطقة',
            'sub_area' => 'منطقة فرعية',
        ];

        $badge_colors = [
            'country' => 'bg-primary',
            'province' => 'bg-success',
            'area' => 'bg-warning',
            'sub_area' => 'bg-danger',
        ];


        foreach ($regions as $region) {
            $type = $region->type;
            $badge_color = $badge_colors[$type] ?? 'bg-secondary';
            $region['type_badge'] = '<span class="badge ' . $badge_color . '">' . $type_mapping[$type] . '</span>';
        }

        return view('admin.regions.index', compact('regions', 'headers', 'route', 'buttons', 'type_options'));
    }
    public function create()
    {

        $back = route('admin.regions.index');
        $country_options = Region::where('parent_id', null)->select('id', 'name')->pluck('name', 'id')->toArray();
        $province_options = Region::where('type', 'province')->select('id', 'name')->pluck('name', 'id')->toArray();
        $area_options = Region::where('type', 'area')->select('id', 'name')->pluck('name', 'id')->toArray();

        $type_options = [
            'country' => 'دولة',
            'province' => 'محافظة',
            'area' => 'منطقة',
            'sub_area' => 'منطقة فرعية',

        ];
        return view('admin.regions.create', compact('back', 'country_options', 'province_options', 'area_options', 'type_options'));
    }
    public function store(Request $request)
    {

        // Validate the request
        $validatedData = $request->validate([
            'type' => 'required|string|in:country,province,area,sub_area',
            'name' => 'required|string|max:255',
            'country_id' => 'nullable|exists:regions,id',
            'province_id' => 'nullable|exists:regions,id',
            'area_id' => 'nullable|exists:regions,id',
        ], [
            'type' => 'نوع المنطقة إجباري أن يكون دولة او محافظة او منطقة او منطقة فرعية',
            'name' => 'اسم المنطقة أجباري',

        ]);

        // Determine the parent ID based on the type
        $parent_id = null;
        $delivery_fees = 0;
        if ($request->type === 'province') {
            $parent_id = $request->country_id;
            $delivery_fees = $request->delivery_fees;
        } elseif ($request->type === 'area') {
            $parent_id = $request->province_id;
        } elseif ($request->type === 'sub_area') {
            $parent_id = $request->area_id;
        }

        // Create the new region
        Region::create([
            'type' => $validatedData['type'],
            'name' => $validatedData['name'],
            'parent_id' => $parent_id,
            'delivery_fees' => $delivery_fees,
        ]);

        // Redirect back with success message
        return redirect()->route('admin.regions.create')->with('success', 'تمت العملية بنجاح.');
    }
    public function edit($id)
    {
        try {
            $region = Region::findOrFail($id);
            $back = route('admin.regions.index');

            $country_options = Region::where('parent_id', null)->pluck('name', 'id')->toArray();
            $province_options = Region::where('type', 'province')->pluck('name', 'id')->toArray();
            $area_options = Region::where('type', 'area')->pluck('name', 'id')->toArray();

            $type_options = [
                'country' => 'دولة',
                'province' => 'محافظة',
                'area' => 'منطقة',
                'sub_area' => 'منطقة فرعية',
            ];

            return view('admin.regions.edit', compact('region', 'back', 'country_options', 'province_options', 'area_options', 'type_options'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $region = Region::findOrFail($id);

            // Validate the request
            $validatedData = $request->validate([
                'type' => 'required|string|in:country,province,area,sub_area',
                'name' => 'required|string|max:255',
                'country_id' => 'nullable|exists:regions,id',
                'province_id' => 'nullable|exists:regions,id',
                'area_id' => 'nullable|exists:regions,id',
            ], [
                'type' => 'نوع المنطقة إجباري أن يكون دولة او محافظة او منطقة او منطقة فرعية',
                'name' => 'اسم المنطقة أجباري',

            ]);

            // Determine the parent ID based on the type
            $parent_id = null;
            if ($request->type === 'province') {
                $parent_id = $request->country_id;
            } elseif ($request->type === 'area') {
                $parent_id = $request->province_id;
            } elseif ($request->type === 'sub_area') {
                $parent_id = $request->area_id;
            }

            // Update the region
            $region->update([
                'type' => $validatedData['type'],
                'name' => $validatedData['name'],
                'parent_id' => $parent_id,
            ]);

            // Redirect back with success message
            return redirect()->route('admin.regions.index')->with('success', 'تمت العملية بنجاح.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $region = Region::findOrFail($id);
            $region->delete();
            return redirect()->route('admin.regions.index')->with('success', 'تمت العملية بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
