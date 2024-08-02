<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property string $description
 * @property string  $word
 * @mixin Builder
 */
class Word extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
