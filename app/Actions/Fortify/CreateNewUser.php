<?php

namespace App\Actions\Fortify;

use App\Actions\Teams\CreateTeam;
use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    public function __construct(private CreateTeam $createTeam)
    {
        //
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $registerAsOrganization = !empty($input['register_as_organization']);

        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
            'organization_name' => $registerAsOrganization ? ['required', 'string', 'max:255'] : ['nullable'],
            'subdomain' => $registerAsOrganization ? ['required', 'string', 'alpha_dash', 'max:50', 'unique:organizations,subdomain'] : ['nullable'],
        ])->validate();

        return DB::transaction(function () use ($input, $registerAsOrganization) {
            if ($registerAsOrganization) {
                $organization = \App\Models\Organization::create([
                    'name' => $input['organization_name'],
                    'subdomain' => strtolower($input['subdomain']),
                ]);
            } else {
                $organization = \App\Models\Organization::first() ?? \App\Models\Organization::create([
                    'name' => 'Default Organization',
                    'subdomain' => 'default',
                ]);
            }

            $user = User::create([
                'organization_id' => $organization->id,
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
            ]);

            $this->createTeam->handle($user, $user->name."'s Team", isPersonal: true);

            return $user;
        });
    }
}
