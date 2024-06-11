<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\JournalRequest;
use App\Journal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function index(Client $client): View
    {
        return view('journals.index', ['journals' => $client->journals]);
    }

    public function create(Client $client): View
    {
        return view('journals.create', ['client' => $client]);
    }

    public function show(Client $client, Journal $journal): View
    {
        return view('journals.show', [
            'client'  => $client,
            'journal' => $journal
        ]);
    }

    public function store(Client $client, JournalRequest $request): Model
    {
        return $client->journals()->create($request->validated());
    }

    public function destroy(Client $client, Journal $journal): string
    {
        $journal->delete();

        return 'Deleted';
    }
}
