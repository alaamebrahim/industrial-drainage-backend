<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    public function messages()
    {
        return [
            'required_if' => __('حقل مطلوب'),
            '*.required' => __('يجب تعبئة الحقل'),
            '*.required_without' => __('يجب تعبئة الحقل'),
            '*.required_with' => __('يجب تعبئة الحقل'),
            '*.unique' => __('قيمة موجودة بالفعل'),
            '*.in' => __('قيمة غير صحيحة'),
            '*.exists' => __('قيمة غير صحيحة'),
            '*.date' => __('قيمة غير صحيحة'),
            '*.mimetypes' => __('نوع الملف غير صحيح'),
            '*.url' => __('الرابط غير صحيح'),
            '*.image' => __('الملف ليس صورة'),
            '*.email' => __('البريد الالكترونى غير صحيح'),
            '*.required_unless' => __('يجب تعبئة الحقل'),
            '*.required_if' => __('يجب تعبئة الحقل'),
            '*.regex' => __('قيمة غير صحيحة'),
            '*.digits' => __('قيمة غير صحيحة'),
            '*.min' => __('قيمة غير صحيحة'),
            '*.max' => __('قيمة غير صحيحة'),
            '*.gt' => __('قيمة غير صحيحة'),
            '*.confirmed' => __('كلمتي المرور غير متطابقتين'),
            '*.mimes' => __('نوع الملف غير مسموح به'),
            'password.uncompromised' => 'كلمة المرور هذه غير آمنة',
            'password.mixed' => 'يجب إدخال حرف كبير وصغير ورقم على الأقل',
            'password.min' => 'يجب إدخال عدد 8 أحرف على الأقل',
            'password.confirmed' => 'كلمتي المرور غير متطابقتين',
            'identity.exists' => 'يرجى إدخال رقم هوية صحيح',
        ];
    }
}
