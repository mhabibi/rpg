<?php
namespace App\Models;

use App\Entities\State;
use App\Entities\StateInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 */
class StateModel extends Model
{
    public $timestamps = false;

    protected $table = 'states';

    protected $fillable = ['title', 'description'];

    public function options()
    {
        return $this->belongsToMany('App\Models\StateModel', 'options', 'parent', 'child');
    }

    public function toEntity(): StateInterface
    {
        $options = [];
        foreach ($this->options as $option) {
            $options[$option->getAttribute('id')] = $option->getAttribute('title');
        }

        return new State(
            $this->getAttribute('id'),
            $this->getAttribute('title'),
            $this->getAttribute('description'),
            $this->getAttribute('cost'),
            $options
        );
    }
}
