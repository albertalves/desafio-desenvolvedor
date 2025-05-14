<?php

namespace App\Repositories;

use App\Models\FileHistory;
use App\Interfaces\FileHistoryRepositoryInterface;
use Illuminate\Support\Facades\Log;

class FileHistoryRepository implements FileHistoryRepositoryInterface
{
    public function __construct(
        private FileHistory $model
    ) {
        $this->model = $model;
    }

    public function getList(Array $data): array
    {
        try {

            $name       = $data['name'] ?? null;
            $createdAt  = $data['created_at'] ?? null;
            $query      = $this->model->query();
        
            if (filled($name)) {
                $query->where('name', $name);
            }

            if (filled($createdAt)) {
                $query->whereDate('created_at', $createdAt);
            }

            $fileHistory = $query->paginate(10);

            return compact('fileHistory', 'name', 'createdAt');

        } catch (\Throwable $th) {

            Log::error('Erro ao listar/filtrar histórico de upload', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            throw $th;
        }
    }
}