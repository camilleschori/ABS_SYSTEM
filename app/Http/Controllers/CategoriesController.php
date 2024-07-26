<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index()
    {
        $query = Category::query();

        if (request()->keyword) {
            $keyword = request()->keyword;
            $query->where('name', 'like', "%$keyword%");
        }

        $categories = $query->paginate(10)->appends(request()->query());

        $headers = [
            'name' => 'الاسم',
            'type_badge' => 'نوع التصنيف',
            'image_url' => 'صورة التصنيف',
            'visible_badge' => 'حالة الظهور',
            'created_by_user' => 'انشيء بواسطة',
        ];

        $route = 'admin.categories';

        $buttons = [
            'add' => route('admin.categories.create'),
            'back' => route('admin.dashboard'),
            'form' => route('admin.categories.index')
        ];

        foreach ($categories as $category) {
            $category->created_by_user = $category->createdByUser->name;
            $category->image_url = $category->getImageUrl();
            $category->visible_badge = $category->getVisibleBadge();
            $category->type_badge = $category->getTypeBadge();
        }

        return view('admin.categories.index', compact('categories', 'headers', 'route', 'buttons'));
    }

    public function create()
    {

        $back = route('admin.categories.index');

        $parent_options = Category::pluck('name', 'id')->toArray();

        return view('admin.categories.create', compact('back', 'parent_options'));
    }



    public function store(Request $request)
    {
        // Validate the request data
        $formData = $request->validate([

            'type' => 'required',
            'name' => 'required',
            'image' => 'required|image',
            'is_visible' => 'required',
            'parent_id' => 'nullable',

        ], [
            'name.required' => 'الاسم العربي مطلوب',
            'image.required' => 'صورة التصنيف مطلوبة',
            'image.image' => 'الشعار يجب ان يكون صورة',
            'is_visible.required' => 'حالة الظهور مطلوبة',
            'type.required' => 'نوع التصنيف مطلوب',
        ]);

        // Handle the logo file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/categories'), $imageName);
            $formData['image'] =  $imageName;
        }

        // Create a new categorywith the validated data
        Category::create($formData);

        // Redirect to the categories index page
        return redirect()->route('admin.categories.index')->with('success', 'تم الحفظ بنجاح');
    }



    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        $parent_options = Category::where('id', '!=', $id)->where('parent_id', null)->pluck('name', 'id')->toArray();

        $back = route('admin.categories.index');

        return view('admin.categories.edit', compact('category',  'back', 'parent_options'));
    }

    public function update(Request $request, string $id)
    {
        // Validate the request data
        $formData = $request->validate([

            'type' => 'required',
            'name' => 'required',

            'image' => 'required|image',
            'is_visible' => 'required',
            'parent_id' => 'nullable',

        ], [
            'name.required' => 'الاسم العربي مطلوب',
            'image.required' => 'صورة التصنيف مطلوبة',
            'image.image' => 'الشعار يجب ان يكون صورة',
            'is_visible.required' => 'حالة الظهور مطلوبة',
            'type.required' => 'نوع التصنيف مطلوب',
        ]);

        // Find the category by ID
        $category = Category::findOrFail($id);

        // Handle the logo file upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($category->image) {
                $oldimagePath = public_path('uploads/categories/' . $category->image);
                if (file_exists($oldimagePath)) {
                    unlink($oldimagePath);
                }
            }

            // Store the new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/categories'), $imageName);
            $formData['image'] = $imageName;
        }

        // Update the category with the validated data
        $category->update($formData);


        // Redirect to the category index page
        return redirect()->route('admin.categories.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'تم الحذف بنجاح');
    }
}
