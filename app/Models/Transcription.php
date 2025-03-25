<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transcription extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'fileName',
        'type',
        'language',
        'quality',
        'hours',
        'sentence_domain',
        'sentence',
        'review',
        'updated_by_user_id',
        'status'
    ];


}
