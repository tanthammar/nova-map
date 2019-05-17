<?php

namespace Pavinthan\NovaMap;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Map extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'map-field';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta($this->resolveConfigValues());
    }


    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($this->meta['format'] == 'json' && $request->exists($requestAttribute)) {
            $model->{$attribute} = json_decode($request[$requestAttribute], true) ?? $request[$requestAttribute];
        } else {
            parent::fillAttributeFromRequest($request, $requestAttribute, $model, $attribute);
        }
    }

    public function format(string $format = null)
    {
        return $this->withMeta([
            'format' => $format
        ]);
    }

    public function height(int $height)
    {
        return $this->withMeta([
            'height' => $height
        ]);
    }

    public function latitude(float $latitude)
    {
        return $this->withMeta([
            'latitude' => $latitude
        ]);
    }

    public function longitude(float $longitude)
    {
        return $this->withMeta([
            'longitude' => $longitude
        ]);
    }

    public function zoom(int $zoom)
    {
        return $this->withMeta([
            'zoom' => $zoom
        ]);
    }

    public function controls(array $controls)
    {
        return $this->withMeta([
            'controls' => $controls
        ]);
    }

    private function resolveConfigValues()
    {
        return array_only(config('nova-map'), [
            'controls',
            'height',
            'latitude',
            'longitude',
            'zoom',
        ]);
    }
}
