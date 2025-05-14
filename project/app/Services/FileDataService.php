<?php

namespace App\Services;

use App\Repositories\FileDataRepository;

class FileDataService
{
    public function __construct(
        private FileDataRepository $repository
    ) {}

    public function importData(Array $data): void
    {
        $this->repository->import($data);
    }

    public function getList(Array $data): array
    {
        return $this->repository->getList($data);
    }
}