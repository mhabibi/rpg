<?php
declare(strict_types = 1);

namespace App\Models;

use App\Entities\State;
use App\Entities\StateInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StateModel
 *
 * @package App\Models
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

    /**
     * @return StateInterface
     */
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
            (int)$this->getAttribute('cost'),
            $options
        );
    }
}
