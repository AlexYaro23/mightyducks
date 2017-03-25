<?php

namespace App\Models\Api;

use App\Models\League as Model;

class League
{
    public $id;
    public $name;
    public $status;
    public $info;
    public $logo;

    public function __construct(Model $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->status = $model->status;
        $this->info = $model->info;
        $this->logo = $model->getLogoLink();
    }
}