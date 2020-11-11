<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    /**
     * createAdmin user.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function createAdmin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        //$user->owner_id = Auth::user()->id;
        $user->role_id = 1;
        $user->save();

        $userInformation = new UserInformation;
        $userInformation->user_id = $user->id;
        $userInformation->save();
        return $user;
    }

    /**
     * create manager user.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function createManager(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        //$user->owner_id = Auth::user()->id;
        $user->role_id = 2;
        $user->save();

        $userInformation = new UserInformation;
        $userInformation->user_id = $user->id;
        $userInformation->save();

        return $user;
    }

    /**
     * createAdmin user.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        if (Auth::user()->role_id == 3) {
            return json_encode("No access this function");
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->owner_id = Auth::user()->id;
        $user->role_id = 3;
        $user->save();

        $userInformation = new UserInformation;
        $userInformation->user_id = $user->id;
        $userInformation->save();

        return $user;
    }


    /**
     * update user by admin.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserByAdmin(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $id = (int)$request->id;
        $user = User::find($id);
        if (isset($request->email)) $user->email = $request->email;
        if (isset($request->name)) $user->name = $request->name;
        if (isset($request->password)) $user->password = Hash::make($request->password);
        if (isset($request->owner_id)) $user->owner_id = $request->owner_id;
        if (isset($request->avatar)) $user->avatar = $request->avatar;
        $user->updated_at = date("Y-m-d H:i:s");
        $user->save();

        $userInformation = UserInformation::where('user_id', $id)->firstOrFail();
        if (isset($request->telephone)) $userInformation->telephone = $request->telephone;
        if (isset($request->type_of_contract)) $userInformation->type_of_contract = $request->type_of_contract;
        if (isset($request->id_country)) $userInformation->id_country = $request->id_country;
        if (isset($request->rate)) $userInformation->rate = $request->rate;
        if (isset($request->rate_interval_id)) $userInformation->rate_interval_id = $request->rate_interval_id;
        if (isset($request->birdhday)) $userInformation->birdhday = $request->birdhday;
        if (isset($request->address)) $userInformation->address = $request->address;
        if (isset($request->employement_id)) $userInformation->employement_id = $request->employement_id;
        $userInformation->updated_at = date("Y-m-d H:i:s");
        $userInformation->save();

        return User::join('userinformations', 'users.id', '=', 'userinformations.user_id')
            ->where('users.id', $user->id)
            ->get()->makeHidden(['user_id', 'updated_at', 'created_at', 'email_verified_at'])[0];
    }

    /**
     * update user by manager.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateMyUser(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $idOwner = Auth::user()->id;
        $id = (int)$request->id;
        $user = User::find($id);
        if ($idOwner != $user->owner_id) return json_encode("not access this user");
        if (isset($request->email)) $user->email = $request->email;
        if (isset($request->name)) $user->name = $request->name;
        if (isset($request->password)) $user->password = Hash::make($request->password);
        if (isset($request->avatar)) $user->avatar = $request->avatar;
        $user->updated_at = date("Y-m-d H:i:s");
        $user->save();

        $userInformation = UserInformation::where('user_id', $id)->firstOrFail();
        if (isset($request->telephone)) $userInformation->telephone = $request->telephone;
        if (isset($request->type_of_contract)) $userInformation->type_of_contract = $request->type_of_contract;
        if (isset($request->id_country)) $userInformation->id_country = $request->id_country;
        if (isset($request->rate)) $userInformation->rate = $request->rate;
        if (isset($request->rate_interval_id)) $userInformation->rate_interval_id = $request->rate_interval_id;
        if (isset($request->birdhday)) $userInformation->birdhday = $request->birdhday;
        if (isset($request->address)) $userInformation->address = $request->address;
        if (isset($request->employement_id)) $userInformation->employement_id = $request->employement_id;
        $userInformation->updated_at = date("Y-m-d H:i:s");
        $userInformation->save();

        return User::join('userinformations', 'users.id', '=', 'userinformations.user_id')
            ->where('users.id', $user->id)
            ->get()->makeHidden(['user_id', 'updated_at', 'created_at', 'email_verified_at'])[0];
    }

    /**
     * update me.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateMe(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (isset($request->email)) $user->email = $request->email;
        if (isset($request->name)) $user->name = $request->name;
        if (isset($request->password)) $user->password = Hash::make($request->password);
        if (isset($request->avatar)) $user->avatar = $request->avatar;
        $user->updated_at = date("Y-m-d H:i:s");
        $user->save();

        $userInformation = UserInformation::where('user_id', Auth::user()->id)->firstOrFail();
        if (isset($request->telephone)) $userInformation->telephone = $request->telephone;
        if (isset($request->type_of_contract)) $userInformation->type_of_contract = $request->type_of_contract;
        if (isset($request->id_country)) $userInformation->id_country = $request->id_country;
        if (isset($request->rate)) $userInformation->rate = $request->rate;
        if (isset($request->rate_interval_id)) $userInformation->rate_interval_id = $request->rate_interval_id;
        if (isset($request->birdhday)) $userInformation->birdhday = $request->birdhday;
        if (isset($request->address)) $userInformation->address = $request->address;
        if (isset($request->employement_id)) $userInformation->employement_id = $request->employement_id;
        $userInformation->updated_at = date("Y-m-d H:i:s");
        $userInformation->save();

        return User::join('userinformations', 'users.id', '=', 'userinformations.user_id')
            ->where('users.id', $user->id)
            ->get()->makeHidden(['user_id', 'updated_at', 'created_at', 'email_verified_at'])[0];
    }

    /**
     * update me.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteUser(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        $id = (int)$request->id;
        $role = Auth::user()->role_id;
        if ($role == 1) {
            User::where('id', $id)->delete();
            return json_encode("ok");
        }
        if ($role == 2) {
            $user = User::find($id);
            if (isset($user)) {
                if ($user->owner_id == Auth::user()->id) {
                    User::where('id', $id)->delete();
                    return json_encode("ok");
                } else {
                    return json_encode('no acess');
                }
            } else return json_encode('not exist');
        }
        if ($role == 3) return json_encode('no access');
    }


    /**
     * Gets Infirmation about User
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getMe()
    {
        return User::join('userinformations', 'users.id', '=', 'userinformations.user_id')
            ->where('users.id', Auth::user()->id)
            ->get()->makeHidden(['user_id', 'updated_at', 'created_at', 'email_verified_at'])[0];
    }

    /**
     * Get Information About All users
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return User::join('userinformations', 'users.id', '=', 'userinformations.user_id')
            ->get()->makeHidden(['user_id', 'updated_at', 'created_at', 'email_verified_at']);
    }

    /**
     * Get all users by managers id
     * @return mixed
     */
    public function getMyUsers()
    {
        return User::join('userinformations', 'users.id', '=', 'userinformations.user_id')
            ->where('owner_id', '>', 0)
            ->where('owner_id', Auth::user()->id)
            ->get()->makeHidden(['user_id', 'updated_at', 'created_at', 'email_verified_at']);
    }

    /**
     * Activate user by id and email / GET request to email activation
     * @param $id
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function activateUser($id, Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        $id = (int)$id;
        if ($id == 0) return 0;
        $user = User::find($id);
        if ($request->email != $user->email) return 0;
        $user->activated = 1;
        $user->save();
        return json_encode($user->email . " Activated");
    }

    /**
     * Deactivate user by id and email / GET request to email deactivation
     * @param $id
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function deactivateUser($id)
    {
        $id = (int)$id;
        if ($id == 0) return 0;
        $user = User::find($id);
        $user->activated = 0;
        $user->save();
        return json_encode($user->email . " Deactivated");
    }

    /**
     * update me.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateAndActivateMe(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
        ]);
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->activated = 1;
        $user->updated_at = date("Y-m-d H:i:s");
        $user->save();
        DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
        return $user;
    }

}
