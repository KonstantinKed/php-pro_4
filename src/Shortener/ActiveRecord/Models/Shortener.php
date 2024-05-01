<?php

namespace App\Shortener\ActiveRecord\Models;

use App\Shortener\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @throws DataNotFoundException
 * @property string url
 * @property string short_code
 * @property int id
 */
class Shortener extends Model
{
    protected $table = "shortener";
    public $timestamps = false;  //created_at, updated_at

    public static function getUrl(string $code): ?string
    {
        return self::query()->where('short_code', $code)->first()?->url;
    }

    public static function getCode(string $url): ?string
    {
        if (!$code = self::query()->where('url', $url)->first()?->short_code) {
            throw new DataNotFoundException();
        }
        return $code;
    }
}