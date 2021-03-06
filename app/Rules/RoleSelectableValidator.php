<?php

namespace App\Rules;

use App\Role;
use Illuminate\Contracts\Validation\Rule;

class RoleSelectableValidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Role::query()->where('id', '=', $value)->where('selectable', '=', true)->count() == 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Role doesnt exist';
    }
}
