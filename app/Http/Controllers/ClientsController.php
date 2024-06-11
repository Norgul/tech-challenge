<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientRequest;
use Illuminate\View\View;

class ClientsController extends Controller
{
    public function index(): View
    {
        $clients = auth()->user()->clients;

        foreach ($clients as $client) {
            $client->append(['bookings_count', 'journals_count']);
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function show(Client $client): View
    {
        return view('clients.show', ['client' => $client->load(['bookings', 'journals'])]);
    }

    public function store(ClientRequest $request): Client
    {
        return auth()->user()->clients()->create($request->validated());
    }

    public function destroy(Client $client): string
    {
        $client->delete();

        return 'Deleted';
    }
}
