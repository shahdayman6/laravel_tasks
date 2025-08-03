<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User; // مهم علشان Laravel يعرف الكلاس


class Note extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'user_id', // لازم نضيفه هنا علشان نقدر نسجله في قاعدة البيانات
    ];

    // 👇 العلاقة بين الملاحظة والمستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}