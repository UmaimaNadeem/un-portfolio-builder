<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use App\Mail\emailVerificationMail;
use App\Mail\passwordRecoveryMail;
use App\Mail\sendPasswordChangeMail;
use App\Models\Member;

use Exception;

trait AuthTrait{

    public function sendVerificationEmail($userObj){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $keyChars = substr(str_shuffle($permitted_chars), 0, 23);
        $tokenKey = hash('sha256', $userObj->email . time() . $keyChars);

        $userObj->user_token = $tokenKey;
        $userObj->save();

        try {
            $mailData = [
                'name' => $userObj->name,
                'email' => $userObj->email,
                'link' => route('auth.email.verified', $tokenKey),
            ];
            Mail::to($userObj->email)->send(new emailVerificationMail($mailData));

            return array('response' => 'success');
        }
        catch (Exception $e) {
            return array('response' => 'fail', 'message' => $e->getMessage());
            //return back()->with(['error' => 'Receiver email have issues.']);
            //return back()->with(['error' => $e->getMessage()]);
            //return back()->withErrors($e->getMessage());
        }
    }

    public function isUserVerified($userObj = false){
        if(!$userObj) {
            $userObj = Auth::user();
        }
        //if ($userObj->email_verified_at && $userObj->phone_verified_at) {
        if ($userObj->email_verified_at) {
            return true;
        }

        return false;
    }

    private function isAdmin(){
        if(Auth::user()) {
            if (Auth::user()->role == 'superAdmin') {
                $this->isAdmin = true;
                return true;
            } elseif (Auth::user()->role == 'admin') {
                $this->isAdmin = true;
                return true;
            }
        }

        return false;
    }

    public function getMemberId($generateNew = true, $memberKey = false){
        $userId = false;
        $memberId = 0;
        if($memberKey){
            $member = Member::select('id')->where('temp_key', $memberKey)->first();
            if($member){
                return $member->id;
            }
        }
        else {
            $currentUser = Auth::user();
            if ($currentUser) {
                $userId = $currentUser->id;
                $member = Member::select('id')->where('user_id', $userId)->first();
                if ($member) {
                    $memberId = $member->id;
                    $generateNew = false;
                }
            } else {
                $memberCookie = Cookie::get('platoGalleryMemberKey');
                if ($memberCookie) {
                    $member = Member::select('id')->where('temp_key', $memberCookie)->first();
                    if ($member) {
                        $memberId = $member->id;
                    } else {
                        Cookie::queue(Cookie::forget('platoGalleryMemberKey'));
                        $memberId = false;
                        $generateNew = true;
                    }
                }
            }

            if (!$memberId && $generateNew) {
                $memberId = $this->generateMemberId($userId);
            }
        }

        return $memberId;
    }

    public function saveMemberId($memberKey){
        $memberObj = Member::select('id')->where('temp_key', $memberKey)->first();
        if(!$memberObj){
            $memberObj = new Member();
            $memberObj->temp_key = $memberKey;
            $memberObj->save();
        }

        return $memberObj->id;
    }

    public function generateMemberId($userId = false){
        $platoGalleryMemberKey = $this->setMemberId();

        $memberObj = new Member();
        if($userId) {
            $memberObj->user_id = $userId;
        }
        $memberObj->temp_key = $platoGalleryMemberKey;
        $memberObj->save();

        return $memberObj->id;
    }

    public function setMemberId(){
        $memberCookie = Cookie::get('platoGalleryMemberKey');
        if (!$memberCookie) {
            $memberCookie = time() . rand();
            Cookie::queue(Cookie::make('platoGalleryMemberKey', $memberCookie, 900000000000));
        }

        return $memberCookie;
    }

    private function sendForgotPasswordEmail($userObj){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $keyChars = substr(str_shuffle($permitted_chars), 0, 23);
        $tokenKey = hash('sha256', $userObj->email . time() . $keyChars);

        $userObj->user_token = $tokenKey;
        $userObj->save();

        $mailData = [
            'name' => $userObj->name,
            'email' => $userObj->email,
            'link' => route('auth.password.reset', $tokenKey),
        ];
        Mail::to($userObj->email)->send(new passwordRecoveryMail($mailData));
    }

    private function sendPasswordChangeEmail($userObj){
        $mailData = [
            'name' => $userObj->name,
            'link' => route('auth.login'),
        ];
        Mail::to($userObj->email)->send(new sendPasswordChangeMail($mailData));
    }
}
