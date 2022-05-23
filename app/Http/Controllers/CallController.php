<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CallController extends Controller
{


    public function store(Request $request, Customer $customer)
    {
        if(Auth::user()->notPermittedTo('process customers')) abort(403);

        // müşteri aktif işaretlenmemişse oylanamaz
        if(!$customer->is_active)
            return Redirect::back();

        $data = $this->validatedData($request);
        $call = Call::create($data);
        $customer->call()->save($call);
        return Redirect::back();
    }

    public function update(Request $request, Call $call)
    {
        if(Auth::user()->notPermittedTo('process customers')) abort(403);

        $data = $this->validatedData($request);
        $call->update($data);
        return Redirect::back();
    }

    public function destroy(Call $call)
    {
        if(Auth::user()->notPermittedTo('process customers')) abort(403);

        $call->delete();
        return Redirect::back();
    }

    private function validatedData(Request $request)
    {
        return $this->validate($request, [
            // "customer_id" => 'nullable|integer',
            "status" => 'nullable|in:POSITIVE,UNANSWERED,BUSY',
            "score" => 'nullable|integer|between:1,10',
            "note" => 'nullable',
        ], [], [
            "status" => 'İletişim Durumu',
            "score" => 'Puanlama',
            "note" => 'Not',
        ]);
    }
}
