<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public const TITLE_MAX_LENGTH = 255;
    public const PROGRESS_MIN = 0;
    public const PROGRESS_MAX = 100;

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
            'title' => 'required|string|max:' . self::TITLE_MAX_LENGTH,
            'description' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'date',
            'due_date' => 'date|after_or_equal:start_date',
            'progress' => 'numeric|min:' . self::PROGRESS_MIN . '|max:' . self::PROGRESS_MAX,
            'parent_id' => 'nullable|exists:tasks,id',
        ];
    }

    // バリデーションメッセージ
    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'title.string' => 'タイトルは文字列である必要があります。',
            'title.max' => 'タイトルは最大' . self::TITLE_MAX_LENGTH . '文字までです。',

            'description.required' => '説明は必須です。',
            'description.string' => '説明は文字列で入力してください。',

            'status.required' => 'ステータスを選択してください。',
            'status.string' => 'ステータスの形式が正しくありません。',

            'start_date.date' => '開始日は日付形式で入力してください。',

            'due_date.date' => '期日は日付形式で入力してください。',
            'due_date.after_or_equal' => '期日は開始日以降の日付を指定してください。',

            'progress.numeric' => '進捗は数値で入力してください。',
            'progress.min' => '進捗は' . self::PROGRESS_MIN . '以上で入力してください。',
            'progress.max' => '進捗は' . self::PROGRESS_MAX . '以下で入力してください。',

            'parent_id.exists' => '選択された親タスクが存在しません。',
        ];
    }
}