<?php

namespace Septio\LaravelMeaningcloud;

use Laravel\Nova\Fields\Field;

class LaravelMeaningcloud extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'laravel-meaningcloud';

    public $apiKey = "f835177457b56ddf174c90894b23b118";

    public function from($field)
    {
        return $this->withMeta(['relation' => $field]);
    }

    public function sentences($amount = 3){
        return $this->withMeta(['sentences' => $amount]);
    }
}
