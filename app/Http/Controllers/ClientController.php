<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('id', 'DESC')->get();

        return response()->json([
            'message' => 'Clients retrieved successfully.',
            'data' => $clients,
        ], 200);
    }

    public function store(ClientRequest $request)
    {
        $client = Client::create(array_merge(
            $request->validated(),
            ['created_by' => auth()->user()->id]
        ));

        return response()->json([
            'message' => 'Client created successfully.',
            'data' => $client,
        ], 201);
    }

    public function show(Client $client)
    {
        return response()->json([
            'message' => 'Client retrieved successfully.',
            'data' => $client,
        ], 200);
    }

    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return response()->json([
            'message' => 'Client updated successfully.',
            'data' => $client,
        ], 200);
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'message' => 'Client deleted successfully.',
        ], 200);
    }
}
