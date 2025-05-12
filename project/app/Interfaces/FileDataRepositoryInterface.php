<?php

namespace App\Interfaces;

use App\Models\FileData;

interface FileDataRepositoryInterface
{
    public function __construct(FileData $model);

    public function import(array $data);

    public function getList(array $data);
}
