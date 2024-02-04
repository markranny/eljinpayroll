<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employeeno_ctrls extends Model
{
    public function employeeno_ctrls()
    {
        return $this->belongsTo(Employeeno_ctrls::class);
    }
}
