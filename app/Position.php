<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Position
 * Модель для таблицы `positions`
 * @package App
 */
class Position extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'rate', 'hours'];

    public static function getPositions()
    {

    }
}