<?php

namespace App\Http\Controllers;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $geminiClient;

    public function index()
    {
        return view('chat');
    }

    public function chat(Request $request)
    {
        $userMessage = $request->input('message');
        $response = Gemini::geminiPro()->generateContent($userMessage);

        return response()->json($response->candidates[0]->content->parts[0]->text);
    }
}
