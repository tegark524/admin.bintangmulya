<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Ganti false menjadi true untuk mengaktifkan validasi
    }

    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'instructor_id' => 'required|exists:instructors,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'status' => 'nullable|in:Terjadwal,Sedang Proses,Selesai'
        ];
    }

    public function messages()
    {
        return [
            'date.after_or_equal' => 'Tanggal tidak boleh di masa lalu',
            'time.date_format' => 'Format waktu harus HH:MM'
        ];
    }
}
