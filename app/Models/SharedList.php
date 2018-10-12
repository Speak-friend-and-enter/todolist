<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedList extends Model
{
    protected $table = 'shared_lists';

    public function taskList()
    {
        return $this->belongsTo('App\Models\TaskList');
    }
}
