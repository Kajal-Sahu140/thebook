<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FibPaymentService;

class PaymentController extends Controller
{
    protected $fibService;

    public function __construct(FibPaymentService $fibService)
    {
        $this->fibService = $fibService;
    }

    public function makePayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'callbackUrl' => 'required|url',
            'description' => 'required|string',
        ]);

        $response = $this->fibService->initiatePayment(
            $request->amount,
            $request->currency,
            $request->callbackUrl,
            $request->description
        );

        return response()->json($response);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'readableCode' => 'required|string',
        ]);

        $response = $this->fibService->sendPayment($request->readableCode);
        return response()->json($response);
    }
    

    ///////////////////////////
}
