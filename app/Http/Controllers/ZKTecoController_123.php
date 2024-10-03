<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laradevsbd\Zkteco\Http\Library\ZktecoLib; // Correct namespace and class
use Illuminate\Support\Facades\Log;

class ZKTecoController extends Controller
{
    public function index()
    {
        try {
            // Ensure the IP address and port are properly retrieved from the configuration
            $zkIpAddress = config('zkteco.ip_address', '10.151.5.17'); // Default IP address
            $zkPort = config('zkteco.port', 4370); // Default port (ensure it's an integer)
            
            $zk = new ZktecoLib($zkIpAddress, $zkPort);
            
            if ($zk->connect()) {
                $attendance = $zk->getAttendance();
                
                // Use a proper response or view instead of dd
                return response()->json($attendance); 
                // return view('zkteco::app', compact('attendance')); // Uncomment if you want to use the view
            } else {
                Log::error('Connection to ZKTeco device failed');
                return response()->json(['message' => 'Connection to ZKTeco device failed'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching attendance logs', ['message' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
