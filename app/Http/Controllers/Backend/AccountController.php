<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AccountRequest;
use Hash;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function profile(){
        $countries_list = countries_list();
        return view('Backend.Account.my-profile');
    }

    public function password(){
        return view('Backend.Account.password');
    }

    public function artist_profile(){
        return view('Backend.Account.artist_profile');
    }

    public function save(AccountRequest $request, $tab){
        abort_if(!in_array($tab, ['profile', 'password', 'artist_profile']) || ($tab == "artist_profile" && !auth()->user()->hasRole('artist')), 404);

        $data = $request->validated();
        if($tab == "profile"){
            unset($data['current_password']);
            auth()->user()->update($data);

            //Artist privacy settings
            if (auth()->user()->hasRole('artist')) {
                $privacy_settings = [
                    'show_phone' => $data['show_phone'],
                    'show_email' => $data['show_email'],
                ];

                auth()->user()->profile()->updateOrCreate(['user_id' => auth()->id()], ['privacy_settings' => $privacy_settings]);
            }

            return to_route('backend.account.profile')->with('success', __('Profile has been updated successfully'));
        }else if($tab == "password"){
            $new_password = Hash::make($data['new_password']);

            auth()->user()->update(['password' => $new_password]);

            return redirect()->route('backend.account.password')->withSuccess(__('Password changed successfully'));
        }else if($tab == "artist_profile"){
            $data['social_media'] = [
                'whatsapp' => $data['whatsapp'] ?? NULL,
                'facebook' => $data['facebook'] ?? NULL,
                'instagram' => $data['instagram'] ?? NULL,
                'linkedin' => $data['linkedin'] ?? NULL,
                'twitter' => $data['twitter'] ?? NULL,
            ];

            $data['docs'] = [
                'cv' => ($request->has('cv') && $request->file('cv')) ? $request->file('cv')->store('artists-cvs', 'public') : auth()->user()->profile->docs['cv']
            ];

            auth()->user()->profile()->updateOrCreate(['user_id' => auth()->id()], $data);

            return to_route('backend.account.artist_profile')->with('success', __('Artist profile has been updated successfully'));
        }
    }
}
