<?php

namespace App\Http\Controllers;

use App\Models\DeLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        session()->flush();
        $deLogin = DeLogin::where('loginkey', $request->loginkey)->with('deUserData', 'user')->first();

        if (!$deLogin)
            return die('Login fehlgeschlagen');

        if (!$deLogin->deUserData)
            return die('UserData Nicht Gefunden');

        if (!$deLogin->user)
        {
            // Der Benutzer existiert nicht -> Registrieren
            $user = User::create([
                'id' => $deLogin->user_id, // Speichern der Legacy user_id für den Bezug
                'name' => $deLogin->nic, // Der Nickname des Benutzers aus Legacy
                'email' => $deLogin->reg_mail, // Erstellen Sie eine Dummy-E-Mail-Adresse
                'password' => Hash::make('default_password'), // Standardpasswort (dies kann später geändert werden)
            ]);
            sendDiscordMessage('User wurde registriert: ' . $user->name . ' (' . $user->id . ')', name: getDefaultVariable('sv_server_tag'));
            $deLogin = DeLogin::where('loginkey', $request->loginkey)->with('deUserData', 'user')->first();
        }

        auth()->login($deLogin->user);

//        dd($deLogin, $request->loginkey, auth()->check());

        session()->put([
//            'ums_chatoff' => 0,
//            'ums_sm_remtime' => $row['sm_remtime'],
//            'ums_sm_remtimer' => 0,
//            'ums_sm_haswhg' => $techs[4],
//            'ums_useefta' => $row['useefta'],
//            'sou_user_id' => $row['sou_user_id'],
//            'efta_user_id' => $row['efta_user_id'],
//            'ums_werberid' => $row['werberid'],
//            'desktop_version' => isset($_COOKIE['desktop_version']) ? intval($_COOKIE['desktop_version']) : 1,

            // Die weiteren Werte:
            'ums_user_id' => $deLogin->user_id,
            'ums_nic' => $deLogin->nic,
            'ums_spielername' => $deLogin->nic,
            'ums_user_ip' => request()->ip(), // Laravel gibt die Client-IP mit request()->ip()
//
//            'ums_servid' => $ums_servid,
//            'ums_zeitstempel' => $ums_zeitstempel,
//            'ums_session_start' => $ums_session_start,
            'ums_rasse' => $deLogin->deUserData->rasse,
//
//            'ums_submit' => $ums_submit,
//            'ums_gpfad' => $ums_gpfad,
//            'ums_vote' => $ums_vote,
//            'ums_premium' => $ums_premium,
        ]);

        return redirect()->to('/legacy/de_frameset.php')->with('success', 'Login erfolgreich.');
    }
}
