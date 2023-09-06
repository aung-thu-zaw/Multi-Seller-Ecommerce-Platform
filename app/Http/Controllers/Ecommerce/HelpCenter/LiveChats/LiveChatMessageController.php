<?php

namespace App\Http\Controllers\Ecommerce\HelpCenter\LiveChats;

use App\Actions\Ecommerce\LiveChats\CreateLiveChatMessageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LiveChatMessageRequest;
use App\Models\LiveChatMessage;
use Illuminate\Http\Request;

class LiveChatMessageController extends Controller
{
    public function store(LiveChatMessageRequest $request): void
    {
        $message = (new CreateLiveChatMessageAction())->handle($request->validated());

        // if($message) {
        //     event(new ChatMessage($message->load("user:id,avatar")));
        // }
    }

    public function update(LiveChatMessageRequest $request, int $liveChatMessageId): void
    {
        $liveChatMessage = LiveChatMessage::findOrFail($liveChatMessageId);

        $liveChatMessage->update([
            "message" => $request->message,
            "is_edited" => true
        ]);
    }
}
