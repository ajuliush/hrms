<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class DeviceConfigureController extends Controller
{
    public function deviceArea()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'JWT eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxLCJ1c2VybmFtZSI6ImFkbWluIiwiZXhwIjoxNjkyMDkyOTkyLCJlbWFpbCI6Imp1bGl1c2hAcHJlZGljdGlvbml0LmNvbSIsIm9yaWdfaWF0IjoxNjkxNDg4MTkyfQ.Z8nXKzRX1PAPfp8x8KsGZSs7NmBAGHqB0w6cRSPhZCU',
            ])->get('http://127.0.0.1:8090/personnel/api/areas/');

            // Process the response
            $responseData = $response->json();

            // Handle the response data and return a response to the client
            return view('back-end.premium.device-config.area.index', ['data' => $responseData['data']]);
        } catch (\Exception $e) {
            // Handle exceptions (errors) that occur during the API request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deviceAreaAdd(Request $request)
    {
        return $request->all();
        try {
            // Retrieve form data
            $field1Value = $request->input('field1');
            $field2Value = $request->input('field2');

            // Make request to external API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer YOUR_ACCESS_TOKEN',
            ])->post('https://external-api.com/api/insert-data', [
                'field1' => $field1Value,
                'field2' => $field2Value,
                // Other fields as needed
            ]);

            // Process the response
            $responseData = $response->json();

            // Handle the response data and return a response to the client
            return response()->json($responseData, $response->status());
        } catch (\Exception $e) {
            // Handle exceptions (errors) that occur during the API request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function insertData()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'JWT eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxLCJ1c2VybmFtZSI6ImFkbWluIiwiZXhwIjoxNjkyMDkyOTkyLCJlbWFpbCI6Imp1bGl1c2hAcHJlZGljdGlvbml0LmNvbSIsIm9yaWdfaWF0IjoxNjkxNDg4MTkyfQ.Z8nXKzRX1PAPfp8x8KsGZSs7NmBAGHqB0w6cRSPhZCU',
            ])->post('http://127.0.0.1:8090/personnel/api/employees/', [
                "emp_code" => "14789",
                "first_name" => "asif",
                "last_name" => "khan",
                "department" => 1,
                "area" => [2]
            ]);

            // Process the response
            $responseData = $response->json();

            // Handle the response data and return a response to the client
            return response()->json($responseData, $response->status());
        } catch (\Exception $e) {
            // Handle exceptions (errors) that occur during the API request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
