<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return inertia("Message/Index", compact("messages"));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $message = Message::create($data);

//        event(new StoreMessageEvent($message));
        broadcast(new StoreMessageEvent($message))->toOthers();
        return MessageResource::make($message)->resolve();
    }
}
