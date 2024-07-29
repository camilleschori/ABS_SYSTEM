<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    public function index()
    {
        $query = Banner::query();

        if (request()->keyword) {
            $keyword = request()->keyword;
            $query->where('name', 'like', "%$keyword%")->orWhere('expiry_date', 'like', "%$keyword%");
        }

        $banners = $query->paginate(10)->appends(request()->query());

        $headers = [
            'name' => 'الاسم',
            'type_badge' => 'نوع الاعلان',
            'image_url' => 'صورة التصنيف',
            'visible_badge' => 'حالة الظهور',
            'expiry_date' => 'تاريخ الانتهاء',
            'created_by_user' => 'انشيء بواسطة',
        ];

        $route = 'admin.banners';

        $buttons = [
            'add' => route('admin.banners.create'),
            'back' => route('admin.dashboard'),
            'form' => route('admin.banners.index')
        ];

        foreach ($banners as $banner) {
            $banner->created_by_user = $banner->createdByUser->name;
            $banner->image_url = $banner->getImageUrl();
            $banner->visible_badge = $banner->getVisibleBadge();
            $banner->type_badge = $banner->getTypeBadge();
        }

        return view('admin.banners.index', compact('banners', 'headers', 'route', 'buttons'));
    }

    public function create()
    {

        $back = route('admin.banners.index');

        $categories = Category::pluck('name', 'id')->toArray();
        $brands = Brand::pluck('name', 'id')->toArray();
        $items = Item::pluck('name', 'id')->toArray();

        return view('admin.banners.create', compact('back', 'categories', 'brands', 'items'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $formData = $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'is_visible' => 'required',
            'expiry_date' => 'required',
            'type' => 'required',
            'item_id' => 'nullable',
            'category_id' => 'nullable',
            'brand_id' => 'nullable',
            'sequence' => 'nullable',
            'location' => 'nullable',
        ], [
            'name.required' => 'الاسم مطلوب',
            'image.required' => 'الشعار مطلوب',
            'image.image' => 'الشعار يجب ان يكون صورة',
            'is_visible.required' => 'الحالة مطلوبة',
            'type.required' => 'النوع مطلوب',
            'expiry_date.required' => 'تاريخ الانتهاء مطلوب',
        ]);

        // Handle the logo file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/banners'), $imageName);
            $formData['image'] =  $imageName;
        }

        // Create a new brand with the validated data
        Banner::create($formData);

        // Redirect to the brands index page
        return redirect()->route('admin.banners.index')->with('success', 'تم الحفظ بنجاح');
    }

    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        $categories = Category::pluck('name', 'id')->toArray();
        $brands = Brand::pluck('name', 'id')->toArray();
        $items = item::pluck('name', 'id')->toArray();
        $back = route('admin.banners.index');

        return view('admin.banners.edit', compact('banner', 'back', 'categories', 'brands', 'items'));
    }

    public function update(Request $request, string $id)
    {
        // Validate the request data
        $formData = $request->validate([
            'name' => 'required',
            'image' => 'nullable|image',
            'is_visible' => 'required',
            'expiry_date' => 'required',
            'type' => 'required',
            'item_id' => 'nullable',
            'category_id' => 'nullable',
            'brand_id' => 'nullable',
            'sequence' => 'nullable',
            'location' => 'nullable',
        ], [
            'name.required' => 'الاسم مطلوب',
            'image.image' => 'الشعار يجب ان يكون صورة',
            'is_visible.required' => 'الحالة مطلوبة',
            'type.required' => 'النوع مطلوب',
            'expiry_date.required' => 'تاريخ الانتهاء مطلوب',
        ]);
        $banner = Banner::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($banner->image) {
                $oldimagePath = public_path('uploads/banners/' . $banner->image);
                if (file_exists($oldimagePath)) {
                    unlink($oldimagePath);
                }
            }
        }
        // Handle the logo file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/banners'), $imageName);
            $formData['image'] =  $imageName;
        }

        // Create a new brand with the validated data
        $banner->update($formData);

        // Redirect to the brands index page
        return redirect()->route('admin.banners.index')->with('success', 'تم الحفظ بنجاح');
    }


    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'تم الحذف بنجاح');
    }
}
