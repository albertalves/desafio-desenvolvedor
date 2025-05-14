<?php

namespace App\Interfaces;

use App\Models\FileHistory;

interface FileHistoryRepositoryInterface
{
    public function __construct(FileHistory $model);

    public function getList(Array $data): array;
}
