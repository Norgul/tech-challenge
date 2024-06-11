<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
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

    public function store(Request $request): Client
    {
        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->adress = $request->get('adress');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        return $client;
    }

    public function destroy($client): string
    {
        Client::query()->where('id', $client)->delete();

        return 'Deleted';
    }
}
