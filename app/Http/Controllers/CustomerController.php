<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $mainQuery = Customer::query();

        if($request->search) {
            foreach (Customer::$searchColumns as $column) {
                $mainQuery->orWhere($column, 'LIKE', "%{$request->search}%");
            }
        }

        return Inertia::render('Customers', [
            'customers' => $mainQuery
                ->paginate($request->perPage ?? 20)
                ->withQueryString(),

            'filters' => $request->only(['search']),
                
        ]);
    }


    public function store(Request $request)
    {
        Customer::create($this->validatedData($request));
        return Redirect::back();
    }


    public function update(Request $request, Customer $customer)
    {
        $customer->update($this->validatedData($request, $customer));
        return Redirect::back();
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();
        return Redirect::back();
    }


    public function destroyMultiple(Request $request)
    {
        Customer::destroy($request->ids);
        return back();
    }


    public function customersAssign(Request $request, User $user) 
    {
        $request->validate(['customers' => 'array|min:1'], ['min' => 'En az 1 atama yapılabilir!'], ['customers' => 'Müşteri']);
        $customers = Customer::whereIn('id', $request->customers)->get();

        // Yeni atama geçerli sayılacak, müşteri yeni temsilciye atanmış olacak
        foreach ($customers as $customer) {
            $customer->user()->associate($user)->save();
        }
        
        return Redirect::back()->with('success', ' (' . $user->mainRole() . ') ' . $user->name . ' kullanıcısına ' . count($customers) . ' form atandı...');
    }


    public function import(Request $request)
    {
        $request->validate([
            'is_active' => 'required|boolean',
            'excel_file' => 'required|mimes:xlsx, csv, xls',
        ], [], ['excel_file' => 'Excel dosyası']);

        $errors = [];
        try {
            $import = new CustomersImport($request->is_active);
            $import->import($request->excel_file);
            foreach($import->failures() as $failure) {
                $errors[] = $failure->row() . '. ' . 'satırda: (' . $failure->values()['ad'] . ' ' . $failure->values()['soyad'] . ') ' . $failure->errors()[0];
            }
            return back()->with('failures', $errors);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // $failures = $e->failures();
            return back();
        }
    }


    public function export(Request $request)
    {
        return Excel::download(new CustomersExport, 'Müşteri Listesi - ' . date('d.m.Y') . '.xlsx');
    }


    private function validatedData(Request $request, Customer $customer = null) 
    {
        return $this->validate($request, [
            // "user_id" => 'nullable|integer',

            "name" => 'required|max:50',
            "surname" => 'required|max:50',
            "phone" => 'required|numeric|digits_between:10,14|unique:customers,phone,' . $customer?->id,
            "is_active" => 'required|boolean',
            
            "email" => 'nullable|email|unique:customers,email,' . $customer?->id,
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


