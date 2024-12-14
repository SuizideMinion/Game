<?php

namespace App\Http\Controllers;

use App\Models\DeUserData;
use Illuminate\Http\Request;
use App\Services\BuildingService;

class BuildingController extends Controller
{
    protected $buildingService;

    public function __construct(BuildingService $buildingService)
    {
        $this->buildingService = $buildingService;
    }

    public function index()
    {
        $buildings = $this->buildingService->getBuildings();
        return view('buildings.index', compact('buildings'));
    }

    public function availableBuildings() {
//        $this->buildingService->completeBuild(); // Aufrufen über das Instanzobjekt
        $buildings = $this->buildingService->getBuildings();

        $user = DeUserData::where('user_id', session()->get('ums_user_id'))->first();
        return response()->json(['status' => 'success', 'buildings' => $buildings, 'user' => $user]);
    }

    public function build(Request $request)
    {
        $buildingId = $request->input('building_id');

        if ($this->buildingService->startBuild($buildingId)) {
            return response()->json(['status' => 'success', 'message' => 'Gebäude wird gebaut!']);
        }

        return response()->json(['status' => 'failed', 'message' => 'Ein anderes Gebäude wird bereits gebaut.']);
    }

    public function progress()
    {
        $this->buildingService->completeBuild();

        $buildings = session('buildings', []);
        $inBuild = session('in_build', []);

        return response()->json(['status' => 'success', 'buildings' => $buildings, 'in_build' => $inBuild]);
    }

    public function accelerate(Request $request)
    {
        $buildingId = $request->input('building_id');
        $reductionSeconds = $request->input('reduction_seconds', 600); // z.B. 600 Sekunden = 10 Minuten

        if ($this->buildingService->accelerateBuild($buildingId, $reductionSeconds)) {
            return response()->json(['status' => 'success', 'message' => 'Bauzeit verkürzt.']);
        }

        return response()->json(['status' => 'failed', 'message' => 'Kann die Bauzeit nicht verkürzen.']);
    }
}
