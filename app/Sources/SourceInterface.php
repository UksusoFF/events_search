<?php

namespace App\Sources;

interface SourceInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEvents();
}
