<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Number extends Model
{
    /**
     * If, in the future, we decide to
     * "delete" some phone numbers
     */
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'numbers';

    protected $fillable = ['csv_id', 'sms_phone'];
}
