<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{

    public function index(Request $request)
    {
        $messages = Message::latest()->paginate(20);
        $selected = null;

        if ($request->has('id')) {
            $selected = Message::find($request->id);

            if ($selected && !$selected->is_read) {
                $selected->is_read = true;
                $selected->save();
                $selected->refresh();

                Log::info('Message marked as read', [
                    'message_id' => $selected->id,
                    'is_read' => $selected->is_read
                ]);
            }
        }

        return view('admin.messages.index', compact('messages', 'selected'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        Message::create($validated);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    public function markAsRead(Request $request, $message)
    {
        try {
            $message = Message::findOrFail($message);

            if (!$message->is_read) {
                $message->is_read = true;
                $message->save();
                $message->refresh();

                Log::info('Message marked as read via AJAX', [
                    'message_id' => $message->id,
                    'is_read' => $message->is_read
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Pesan telah ditandai sebagai sudah dibaca',
                    'data' => [
                        'id' => $message->id,
                        'is_read' => $message->is_read
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pesan sudah dalam status sudah dibaca',
                'data' => [
                    'id' => $message->id,
                    'is_read' => $message->is_read
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error marking message as read', [
                'error' => $e->getMessage(),
                'message_id' => $message ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai pesan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function reply(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message_id' => 'required|exists:messages,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $originalMessage = Message::findOrFail($request->message_id);


            $reply = Message::create([
                'name' => 'Admin Humas Polres Jember',
                'email' => 'admin@polresjember.go.id',
                'subject' => $request->subject,
                'message' => $request->message,
                'parent_id' => $originalMessage->id,
                'is_reply' => true,
                'is_read' => true,
            ]);

            return redirect()->route('admin.messages.index', ['id' => $originalMessage->id])
                ->with('success', 'Balasan berhasil dikirim ke ' . $originalMessage->email);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengirim balasan: ' . $e->getMessage());
        }
    }
}
