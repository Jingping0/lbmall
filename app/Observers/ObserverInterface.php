<?php

namespace App\Observers;

interface ObserverInterface
{
    public function created($model);

    public function updated($model);

    public function deleted($model);
}