<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\handleClientRequest;
use App\Models\Client;


class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:clients_read')->only('index');
        $this->middleware('permission:clients_create')->only('create');
        $this->middleware('permission:clients_update')->only(['edit','update']);
        $this->middleware('permission:clients_delete')->only('destroy');
    }
    public function index()
    {
        $clients = Client::filter('name',\request()->query())->paginate();
        return view('dashboard.clients.index',compact('clients'));
    }

    public function create()
    {
        return view('dashboard.clients.create');
    }

    public function store(handleClientRequest $request)
    {
        Client::create($request->validated());
        return redirect()->route('dashboard.clients.index')->with('success',__('site.added_successfully'));
    }

    public function edit(Client $client)
    {
        return view('dashboard.clients.edit',compact('client'));
    }
    public function update(handleClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        return redirect()->route('dashboard.clients.index')->with('success',__('site.updated_successfully'));
    }
    public function destroy(Client $client)
    {
        $client->delete();
        return to_route('dashboard.clients.index')->with('success', __('site.deleted_successfully'));
    }
}
