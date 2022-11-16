<?php

namespace App\Models;

interface ModelInterface
{
    public function getCreateRules();
    public function getUpdateRules();
    public function getSearchable();
}
