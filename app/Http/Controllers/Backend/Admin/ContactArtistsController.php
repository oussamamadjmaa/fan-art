<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ArtistMessageMail;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class ContactArtistsController extends Controller
{
    public function index(){
        return view('Backend.Admin.ArtistsMailMessage.index');
    }

    public function send(Request $request){
        $data = $request->validate([
            'subject' => 'required|string|max:191',
            'artist_type' => 'required|in:all,artist,calligrapher',
            'content'   => 'required|string',
        ]);

        $users = User::role('artist')
                ->when($data['artist_type'] != "all", fn($q) => $q->where('artist_type', $data['artist_type']))
                ->get(['id', 'name', 'email']);

        try {
            foreach ($users as $user) {
               Mail::to($user)->send(new ArtistMessageMail($user, $data['subject'], $data['content']));
            }
        } catch (\Exception $e) {
            return to_route('backend.contact_artists.index')->withError($e->getMessage())->withInput();
        }
        return to_route('backend.contact_artists.index')->withSuccess("تم الإرسال بنجاح");
    }
}
