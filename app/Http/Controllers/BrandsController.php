<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function index()
    {
        $query = Brand::query();

        if (request()->keyword) {
            $keyword = request()->keyword;
            $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('code', 'like', '%' . $keyword . '%');
        }

        $brands = $query->paginate(10)->appends(request()->query());

        $headers = [
            'codeEnd' => 'الكود',
            'nameBold' => 'الاسم',
            'logo_url' => 'الشعار',
            'status' => 'الحالة',
            'created_by_user' => 'انشيء بواسطة'
        ];

        $route = 'admin.brands';

        $buttons = [
            'add' => route('admin.brands.create'),
            'back' => route('admin.dashboard'),
            'form' => route('admin.brands.index')
        ];

        foreach ($brands as $brand) {
            $brand->created_by_user = $brand->createdByUser->name;
            $brand->logo_url = '<img src="' . url('uploads/brands/' . $brand->logo) . '" width="100" alt="" >';
            $brand->codeEnd = '<div class="text-end">' . $brand->code . '</div>';
            $brand->nameBold = '<span class="' . ($brand->type == 'parent' ? 'fw-bold' : '') . '">' . $brand->name . '</span>';
        }

        return view('admin.brands.index', compact('brands', 'headers', 'route', 'buttons'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $back = route('admin.brands.index');

        $brands_options = Brand::pluck('name', 'id')->toArray();
        $status_options = [
            'active' => 'مفعل',
            'inactive' => 'غير مفعل'
        ];

        return view('admin.brands.create', compact('back', 'status_options', 'brands_options'));
    }



    public function store(Request $request)
    {

        // Validate the request data
        $formData = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:brands,code',
            'logo' => 'required|image',
            'status' => 'required'
        ], [
            'name.required' => 'الاسم مطلوب',
            'code.required' => 'الكود مطلوب',
            'code.unique' => 'الكود مستخدم من قبل',
            'logo.required' => 'الشعار مطلوب',
            'logo.image' => 'الشعار يجب ان يكون صورة',
            'status.required' => 'الحالة مطلوبة',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/brands'), $logoName);
            $formData['logo'] =  $logoName;
        }

        Brand::create($formData);

        return redirect()->route('admin.brands.index')->with('success', 'تم الحفظ بنجاح');
    }



    public function edit(string $id)
    {

        $brand = Brand::findOrFail($id);
        $status_options = [
            'active' => 'مفعل',
            'inactive' => 'غير مفعل'
        ];

        $brands_options = Brand::pluck('name', 'id')->toArray();

        $back = route('admin.brands.index');

        return view('admin.brands.edit', compact('brand', 'back', 'status_options', 'brands_options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // Validate the request data
        $formData = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:brands,code,' . $id,
            'logo' => 'nullable|image',
            'status' => 'required'
        ], [
            'name.required' => 'الاسم مطلوب',
            'code.required' => 'الكود مطلوب',
            'code.unique' => 'الكود مستخدم من قبل',
            'status.required' => 'الحالة مطلوبة',
        ]);

        // Find the brand by ID
        $brand = Brand::findOrFail($id);

        // Handle the logo file upload
        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($brand->logo) {
                $oldLogoPath = public_path('uploads/brands/' . $brand->logo);
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }

            // Store the new logo
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/brands'), $logoName);
            $formData['logo'] = $logoName;
        }

        // Update the brand with the validated data
        $brand->update($formData);


        // Redirect to the brands index page
        return redirect()->route('admin.brands.index')->with('success', 'تم التعديل بنجاح');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $brand = Brand::findOrFail($id);

        // Delete the brand logo if it exists
        if ($brand->logo) {
            $oldLogoPath = public_path('uploads/brands/' . $brand->logo);
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath);
            }
        }


        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'تم الحذف بنجاح');
    }
}
