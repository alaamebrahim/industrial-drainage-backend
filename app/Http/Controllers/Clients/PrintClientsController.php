<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Clients\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class
PrintClientsController extends Controller
{
    public function __invoke(Request $request): View
    {
        $data = Client::query()
            ->orderBy('id', 'desc')
            ->when($request->filled('is_active'), fn($query) => $query->where('is_active', $request->boolean('is_active')))
            ->when($request->filled('search'), fn($query) => $query->whereLike(['name', 'address'], $request->string('search')))
            ->get();

        return view('reports.clients.list', [
            'data' => collect(ClientResource::collection($data)->toArray($request)),
        ]);
    }
}
