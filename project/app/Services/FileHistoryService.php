<?php

namespace App\Services;

use App\Repositories\FileHistoryRepository;

class FileHistoryService
{
    private $repository;

    public function __construct(FileHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getList(Array $data)
    {
        return $this->repository->getList($data);
    }
}