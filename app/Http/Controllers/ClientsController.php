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
            $client->append('bookings_count');
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function show($client)
    {
        $client = Client::query()->with('bookings')->where('id', $client)->first();

        return view('clients.show', ['client' => $client]);
    }

    public function store(ClientRequest $request): Client
    {
        return auth()->user()->clients()->create($request->validated());
    }

    public function destroy($client): string
    {
        Client::query()->where('id', $client)->delete();

        return 'Deleted';
    }
}
