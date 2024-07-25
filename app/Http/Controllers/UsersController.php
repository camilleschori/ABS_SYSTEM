<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::with(['createdByUser'])->paginate(10);
        $headers = [
            'name' => 'اسم المستخدم',
            'email' => 'البريد الالكتروني',
            'phone' => 'رقم الهاتف',
            'type_badge' => 'نوع الحساب',
            'status_badge' => 'حالة الحساب',
            'created_at' => 'تاريخ الانشاء',
            'created_by_user_name' => 'انشئ بواسطة',

        ];
        $route = 'admin.users';

        $buttons = [
            'add' => route('admin.users.create'),
            'filter' => true,
            'back' => route('admin.dashboard'),
            'form' => route('admin.users.index')
        ];

        if (request()->keyword) {
            $keyword = request()->keyword;
            $users = User::where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhere('type', 'like', '%' . $keyword . '%')
                ->paginate(10);
        }
        foreach ($users as $user) {
            $user->type_badge = $user->getTypeBadge();
            $user->status_badge = $user->getStatusBadge();
        }

        return view('admin.users.index', compact('users', 'headers', 'route', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $back = route('admin.users.index');

        return view('admin.users.create', compact('back'));
    }


    public function store(Request $request)
    {

        $formData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:8',
            'type' => 'required',
            'status' => 'required',


        ], [
            'name.required' => 'يجب ادخال الاسم',
            'email.required' => 'يجب ادخال البريد الالكتروني',
            'email.email' => 'يجب ادخال البريد الالكتروني بصيغة صحيحة',
            'password.required' => 'يجب ادخال كلمة المرور',
            'password.min' => 'يجب ان لا تقل كلمة المرور عن 8 حروف',
            'type.required' => 'يجب ادخال نوع الحساب',
            'status.required' => 'يجب ادخال حالة الحساب',
            'phone.required' => 'يجب ادخال رقم الهاتف',
            'phone.unique' => 'رقم الهاتف موجود بالفعل',
        ]);

        $userData = $request->only(['name', 'email', 'type', 'status', 'phone']);

        $userData['password'] = bcrypt($request->password);
        $userData['admin_password'] = bcrypt($request->password);

        $user = User::create($userData);



        return redirect()->route('admin.users.index')->with('success', 'تمت العملية بنجاح');
    }


    public function edit(string $id)
    {

        $user = User::findOrFail($id);
        $back = route('admin.users.index');

        return view('admin.users.edit', compact('user', 'back'));
    }

    public function update(Request $request, string $id)
    {

        $formData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|unique:users,phone,' . $id,
            'type' => 'required',
            'status' => 'required',
            'password' => 'nullable|min:8',

        ], [
            'name.required' => 'يجب ادخال الاسم',
            'email.required' => 'يجب ادخال البريد الالكتروني',
            'email.email' => 'يجب ادخال البريد الالكتروني بصيغة صحيحة',
            'password.min' => 'يجب ان لا تقل كلمة المرور عن 8 حروف',
            'type.required' => 'يجب ادخال نوع الحساب',
            'status.required' => 'يجب ادخال حالة الحساب',
            'phone.required' => 'يجب ادخال رقم الهاتف',
            'phone.unique' => 'رقم الهاتف موجود بالفعل',

        ]);

        // Exclude profiles from formData
        $userData = $request->only(['name', 'email', 'type', 'status', 'phone']);

        // Check if password is present and add to userData if it is
        if (!empty($formData['password'])) {
            $userData['password'] = bcrypt($formData['password']);
            $userData['admin_password'] = bcrypt($formData['password']);
        }

        $user = User::findOrFail($id);

        $user->update($userData);



        return redirect()->route('admin.users.index')->with('success', 'تمت العملية بنجاح');
    }

    public function destroy(string $id)
    {

        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'تمت العملية بنجاح');
    }
}
