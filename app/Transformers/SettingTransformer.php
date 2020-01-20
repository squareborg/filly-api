<?php

namespace App\Transformers;

use App\Setting;

class SettingTransformer extends \League\Fractal\TransformerAbstract
{

    public function transform(Setting $setting)
    {
        return $setting->toArray();
    }

}