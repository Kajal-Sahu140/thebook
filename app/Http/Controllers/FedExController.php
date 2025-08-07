<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FedExService;

class FedExController extends Controller
{
    protected $fedExService;

    public function __construct(FedExService $fedExService)
    {
        $this->fedExService = $fedExService;
    }

    // Endpoint to get FedEx OAuth Token
    public function getFedExToken()
{
    $token = $this->fedExService->getAccessToken();

    if ($token) {
        return response()->json(['success' => true, 'access_token' => $token]);
    }

    return response()->json(['success' => false, 'message' => 'Failed to retrieve FedEx access token'], 500);
}

        
}
