<?php

namespace App\Shortener\SuportActions;

use App\Shortener\ActiveRecord\Models\Shortener;
use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\ICodeSaver;
use JsonException;

class CodeDBSaver implements ICodeSaver
{

    public function saveShortAndUrl(string $url, string $code): bool
    {
        $data = new Shortener();
        $data->url = $url;
        $data->short_code = $code;
        return ($data->save());
    }

    /**
     * @throws JsonException
     * @throws DataNotFoundException
     */
    public function getCodeByUrl(string $url): ?string
    {
        if ($code = Shortener::getCode($url)) {
            return throw new DataNotFoundException();
        }
        return $code;
    }

    public function getUrlByCode(string $code): ?string
    {
        // ЗАЛИШИВ ТУТ ПРОСТИЙ ВАРІАНТ ЧЕРЕЗ МКТОД ALL
//        $models = Shortener::all();
//        foreach ($models as $model) {
//            if ($model->short_code === $code) {
//                return $model->url;
//            }
//        }
//        return null;

        return Shortener::getUrl($code);

    }
}