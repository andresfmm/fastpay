<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Factories\PaymentFactory;

use App\Http\Requests\ShowPaymentRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\ProccessPaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaymentFactory $factory)
    {

        return $factory->getAll();

    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request, PaymentFactory $factory)
    {
        return $factory->save($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowPaymentRequest $request, PaymentFactory $factory)
    {
        
        return $factory->getById($request->id);

    }

    


    /**
     * Proccess payment 
     */
    public function proccess(ProccessPaymentRequest $request, PaymentFactory $factory)
    {
        
        return $factory->proccess($request);

    }
}
