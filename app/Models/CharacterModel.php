<?php
namespace App\Models;

use App\Entities\Character;
use App\Entities\CharacterInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Character
 */
class CharacterModel extends Model
{
    protected $table = 'characters';

    protected $fillable = ['name'];

    public function state()
    {
        return $this->belongsTo('App\Models\StateModel');
    }

    public function toEntity(): CharacterInterface
    {
        return new Character(
            $this->getAttribute('id'),
            $this->getAttribute('name'),
            $this->getAttribute('stock') ?: 0,
            $this->state ? $this->state->toEntity() : null
        );
    }
}
