<?php

namespace App\Services;

use App\Repositories\FileDataRepository;

class FileDataService
{
    private $repository;

    public function __construct(FileDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function importData(Array $data)
    {
        return $this->repository->import($data);
    }

    public function getList(Array $data)
    {
        return $this->repository->getList($data);
    }
}