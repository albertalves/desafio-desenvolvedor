<?php

namespace App\Services;

use App\Repositories\FileHistoryRepository;

class FileHistoryService
{
    public function __construct(
        private FileHistoryRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function getList(Array $data): array
    {
        return $this->repository->getList($data);
    }
}