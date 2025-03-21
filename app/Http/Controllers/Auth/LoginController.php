<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToProvider()
    {
        Log::info('Using realm: '.config('services.keycloak.realm'));

        return Socialite::driver('keycloak')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('keycloak')->user();
        $userJson = json_encode($user);

        // Extract the value after 'CN='
        $manager = $user->user['Manager'];
        if (preg_match('/CN=([^,]+)/', $manager, $matches)) {
            $reportsTo = $matches[1];
        } else {
            $reportsTo = null; // Default to null if 'CN=' is not found
        }

        // Store user data in session
        session(['keycloak_user' => $userJson]);
        session(['cu.name' => $user['name'] ?? null]);
        session(['cu.email' => $user['email'] ?? null]);
        session(['cu.staffno' => $user->user['preferred_username'] ?? null]);
        session(['cu.department' => $user->user['department'] ?? null]);
        session(['cu.group' => $user->user['roles']['user_group'] ?? null]);
        session(['cu.realm' => $user->user['roles']['realm'] ?? null]);
        session(['cu.client' => $user->user['roles']['client'] ?? null]);
        session(['cu.reportsTo' => $reportsTo]);
        
	$authUser = User::firstOrCreate([
            'email' => $user->email,
        ], [
            'name' => $user->name,
            'password' => bcrypt(Str::random(24)),
        ]);

        Auth::login($authUser, true);

        if (! empty($user->user['user_groups'])) {
            $userGroups = array_map(function ($group) {
                return str_replace('/', 'ug_', $group);
            }, $user->user['user_groups']);

            $realmRoles = [];
            if (! empty($user->user['realm_access']['roles'])) {
                $realmRoles = array_map(function ($role) {
                    return 'rr_'.$role;
                }, $user->user['realm_access']['roles']);
            }

            $resourceRoles = [];
            if (! empty($user->user['resource_access'])) {
                foreach ($user->user['resource_access'] as $resource => $access) {
                    if (! empty($access['roles'])) {
                        $resourceRoles = array_merge($resourceRoles, array_map(function ($role) use ($resource) {
                            return 'ra_'.$resource.'_'.$role;
                        }, $access['roles']));
                    }
                }
            }

            $allGroups = array_merge($userGroups, $realmRoles, $resourceRoles);

            $this->syncGroups($authUser, $allGroups);
        }

        $homeUrl = $authUser->userType->home ?? '/';

        return redirect()->intended($homeUrl);
    }

    private function syncGroups(User $authUser, array $groups)
    {
        $groupIds = [];
        foreach ($groups as $groupName) {
            $group = Group::firstOrCreate(['name' => $groupName]);
            $groupIds[] = $group->id;
        }
        $authUser->groups()->sync($groupIds);
    }
    private function promptYesNo($message)
    {
        echo $message . " (yes/no): ";
        $handle = fopen("php://stdin", "r");
        $response = trim(fgets($handle));
        fclose($handle);

        return strtolower($response) === 'yes';
    }
}
