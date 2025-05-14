<?php

namespace App\Interfaces;

use App\Models\FileData;

interface FileDataRepositoryInterface
{
    public function __construct(FileData $model);

    public function import(array $data): void;

    public function getList(array $data): array;
}
