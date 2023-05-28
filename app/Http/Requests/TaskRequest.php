<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $task = $this->route('task');

        // Verificar si $task o $user son nulos antes de acceder a sus propiedades
        if ($task === null) {
            return true;
        }

        return $task->user_id === $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'string|max:255',
            'descripcion' => 'string',
            'estado' => 'boolean',
            'slug' => 'string'
        ];

        if ($this->isMethod('POST')) {
            $rules['title'] .= '|required';
            $rules['descripcion'] .= '|required';
            $rules['estado'] .= '|required';
            $rules['slug'] .= '|required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'authorize' => 'No tienes permiso para esta acción.',
            'title.required' => 'El campo título es obligatorio.',
            'title.max' => 'El campo título no puede exceder los 255 caracteres.',
            'descripcion.required' => 'El campo descripción es obligatorio.',
        ];
    }
}
