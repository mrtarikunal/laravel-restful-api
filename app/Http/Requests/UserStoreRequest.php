<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ResultType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        //burda bu requesti sadece yetkilendirilmiş kişiler yapsın istyrsak burda ayarlyrz
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:100',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email alanı zorunlu',
            'name.required' => 'İsim alanı zorunlu',
            'password.required' => 'Şifre zorunlu',
            'email.unique' => 'Bu mail adresi daha önce kullanılmış'
        ];
    }//hata mesajlarını özelleştirmk için yani dilini

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            (new ApiController)->apiResponse(ResultType::Error, $errors, 'Doğrulama hatası', 422)
        );
    }
    //dönen hata mesajını değiştirdik. normalde bu yapı kalıtım alınan FormRequest içindeydi
    //buraya alarak değiştirdik.
}
