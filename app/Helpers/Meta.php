<?php

namespace App\Helpers;

class Meta {
    private array $attributes = [];

    public function __construct(array $meta_data = [])
    {
        $this->attributes = $meta_data;
        $this->share();
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
        $this->share();
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
			return $this->attributes[$name];
		}
    }

    public function share(){
        view()->share('meta', $this->toObject());
    }

    public function toObject(){
        return json_decode(json_encode($this->attributes), FALSE);
    }
}
