<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
   
            $settings = Setting::all();

            $back = route('admin.settings.index');
            return view('admin.settings.index', compact('settings', 'back'));
     
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
            $setting = Setting::find($id);

            $formData = $request->validate([
                'phone' => 'required',
                'email' => 'required',
                'address' => 'required',
                'logo' => 'nullable|image'
            ], [
                'phone.required' => 'يجب ادخال رقم الهاتف',
                'email.required' => 'يجب ادخال البريد الالكتروني',
                'address.required' => 'يجب ادخال العنوان',
            ]);

            if ($request->hasFile('logo')) {
                if ($setting->logo) {
                    $oldLogoPath = public_path('uploads/settings/' . $setting->logo);
                    if (file_exists($oldLogoPath)) {
                        unlink($oldLogoPath);
                    }
                }
                $logo = $request->file('logo');
                $logoName = time() . '_' . $logo->getClientOriginalName();
                $logo->move(public_path('uploads/settings'), $logoName);
                $formData['logo'] = $logoName;
            }

            $setting->update($formData);
            return redirect()->route('admin.settings.index')->with('success', 'تمت العملية بنجاح');
      
    }
}
