<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechTreeController extends Controller
{
    /**
     * Zeigt die Tech-Tree-Seite an.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('techtree.index');
    }

    /**
     * Gibt die Gebäude-Daten im JSON-Format zurück.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBuildings()
    {
        try {
            $filePath = storage_path('app/buildings.json');
            \Log::info('File path: ' . $filePath); // Zum Debugging
            $jsonContent = file_get_contents($filePath);

            $buildings = json_decode($jsonContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception(json_last_error_msg());
            }

            if (!is_array($buildings)) {
                throw new \Exception('Data is not an array');
            }

            return response()->json($buildings);
        } catch (\Exception $e) {
//            \Log::error('Data processing issue: ' . $e->getMessage());
            return response()->json(['error' => 'Data processing issue: ' . $e->getMessage()], 500);
        }
    }
}
