<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::fetchAll();
        return Inertia::render('Customers', compact('customers'));
    }


    public function store(Request $request)
    {
        Customer::create($this->validatedData($request));
        return Redirect::back();
    }


    public function update(Request $request, Customer $customer)
    {
        $customer->update($this->validatedData($request));
        return Redirect::back();
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();
        return Redirect::back();
    }


    public function customersAssign(Request $request, User $user) 
    {
        $request->validate(['customers' => 'array|min:1'], ['min' => 'En az 1 atama yapılabilir!'], ['customers' => 'Müşteri']);
        $customers = Customer::whereIn('id', $request->customers)->get();

        // Yeni atama geçerli sayılacak, müşteri yeni temsilciye atanmış olacak
        foreach ($customers as $key => $customer) {
            $customer->user()->associate($user);
        }
        
        return Redirect::back()->with('success', $user->name . ' (' . $user->mainRole() . ') ' . ' kullanıcısına ' . count($customers) . ' adet atama yapıldı...');
    }


    private function validatedData(Request $request) 
    {
        return $this->validate($request, [
            // "user_id" => 'nullable|integer',

            "name" => 'required|max:50',
            "surname" => 'required|max:50',
            "phone" => 'required|numeric|digits_between:10,14',
            "is_active" => 'required|boolean',
            
            "email" => 'nullable|email',
            "city" => 'nullable|max:50',
            "source" => 'nullable|max:50',
            "category" => 'nullable|max:50',
            // "status" => 'nullable|in:POSITIVE,UNANSWERED,BUSY',
            // "score" => 'nullable|integer|between:1,10',
            // "note" => 'nullable|max:255',
        ], [], [
            "name" => 'Ad',
            "surname" => 'Soyad',
            "phone" => 'Telefon numarası',
            "is_active" => 'Aktif',
            "email" => 'E-posta',
            "city" => 'Şehir',
            "source" => 'Kaynak',
            "category" => 'Kategori',
            // "status" => 'İletişim Durumu',
            // "score" => 'Puanlama',
            // "note" => 'Not',
        ]);
    }
    
}


