<?php

namespace App\Repositories;

abstract class BaseRepositories
{
    abstract public function create($attributes);
    abstract public function update($model , $attributes);
    abstract public function forceDelete($attributes);
}
