<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ValidateFileRule implements Rule
{
    protected $extenstions;
    protected $path;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($path, $extenstions = [])
    {
        $this->path = $path;
        $this->extenstions = $extenstions;
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
        $file_ext = pathinfo($value)['extension'] ?? '';
        return (str($value)->startsWith($this->path.'/')) && Storage::disk('public')->exists($value) && (!count($this->extenstions) || in_array(strtolower($file_ext), $this->extenstions));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.mimes', ['values' => implode(',', $this->extenstions)]);
    }
}
