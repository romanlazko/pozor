<?php

namespace App\Http\Requests;

use App\Enums\Sort;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->unserializeData($this->input('data')) ?? $this->unserializeData(session('announcement_search'));

        $this->merge([
            'data' => [
                'filters' => $this->input('filters', $data['filters'] ?? null),
                'sort' => Sort::tryFrom($this->input('sort', $data['sort']->value ?? 'newest')),
                'search' => $this->input('search', $data['search'] ?? ''),
            ],
        ]);
    }

    public function serializedData()
    {
        $data = urlencode(encrypt(serialize($this->data)));

        Session::put('announcement_search', $data);

        return $data;
    }

    private function unserializeData(?string $data)
    {
        return $data ? unserialize(decrypt(urldecode($data))) : null;
    }
    
}
