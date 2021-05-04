<?php

namespace App\Traits;

use App\Helpers\LanguageHelper;
use App\Models\ModelTranslation;
use App\Vendor\Astrotomic\Locales;

trait Translatable
{

    public function AddOrUpdateTranslations($unstructuredArray)
    {
        $structuredArray = [];

        foreach ($unstructuredArray as $name => $data) {
            $index = 0;
            foreach ($data['lang'] as $iso) {
                $structuredArray[$name][$iso] = $data['value'][$index];
                $index++;
            }
        }

        ModelTranslation::where([
            ['model', '=', get_class($this)],
            ['model_id', '=', $this->id],
        ])->delete();

        foreach ($structuredArray as $name => $translation) {
            if (!isset($this->translatedAttributes) || !in_array($name, $this->translatedAttributes)) {
                throw new \Exception('Attribute ' . $name . ' not translatable');
            }
            foreach ($translation as $iso => $t) {
                if ($name && $t) {
                    ModelTranslation::create([
                        'translation' => $t,
                        'model' => get_class($this),
                        'model_id' => $this->id,
                        'attribute' => $name,
                        'language' => $iso
                    ]);
                }
            }
        }
    }

    public function getAttribute($key)
    {
        if ($key[0] == "_" && $key[1] == "_") {
            $key = substr($key, 2);
            if (in_array($key, $this->translatedAttributes)) {
                $mt = ModelTranslation::where([
                    ['model', '=', get_class($this)],
                    ['model_id', '=', $this->id],
                    ['language', '=', app(Locales::class)->current()],
                    ['attribute', '=', $key]
                ])->first();

                if ($mt) {
                    return $mt->translation;
                } else {
                    $mtt = ModelTranslation::where([
                        ['model', '=', get_class($this)],
                        ['model_id', '=', $this->id],
                        ['language', '=', LanguageHelper::$DEFAULT_LANGUAGE],
                        ['attribute', '=', $key]
                    ])->first();

                    if ($mtt) {
                        return $mtt->translation;
                    }
                }
            }
        }

        return parent::getAttribute($key);
    }

    public function getTranslationDataForEdit($attribute): string
    {
        $data = "";
        foreach (
            ModelTranslation::where([
                ['model', '=', get_class($this)],
                ['model_id', '=', $this->id],
                ['attribute', '=', $attribute]
            ])->get()
            as $modelTranslation
        ) {
            $data .= $modelTranslation->language . '=' . $modelTranslation->translation . ';';
        }
        return $data;
    }

}
