<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Database\Eloquent\Collection;

class AdminService
{
    /**
     * Fetch all languages.
     *
     * @return Collection
     */
    public function getAllLanguages(): Collection
    {
        return Language::all();
    }

    /**
     * Create a new language.
     *
     * @param array $data
     * @return Language
     */
    public function createLanguage(array $data): Language
    {
        return Language::create($data);
    }
}
