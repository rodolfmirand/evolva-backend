<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JourneyRequest;
use App\Http\Requests\JourneyJoinRequest;
use App\Services\JourneyService;
use Illuminate\Support\Facades\Auth;

class JourneyController extends Controller
{
    public function __construct(private JourneyService $journeyService) {}

    public function index()
    {
        $user = Auth::user();
        $journeys = $this->journeyService->getAllJourneys($user);
        return response()->json($journeys);
    }

    public function show($id)
    {
        $journey = $this->journeyService->getJourneyById($id);
        return response()->json($journey);
    }

    public function store(JourneyRequest $request)
    {
        $user = Auth::user();
        $journey = $this->journeyService->createJourney($request->validated(), $user);
        return response()->json($journey, 201);
    }

    public function join(JourneyJoinRequest $request)
    {
        $user = Auth::user();
        $journey = $this->journeyService->joinJourney($request->validated()['join_code'], $user);
        return response()->json($journey);
    }
}
