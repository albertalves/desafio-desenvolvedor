<?php

namespace App\Repositories;

use App\Jobs\ImportFileJob;
use App\Models\FileData;
use App\Models\FileHistory;
use App\Interfaces\FileDataRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FileDataRepository implements FileDataRepositoryInterface
{
    protected $model;

    public function __construct(FileData $model)
    {
        $this->model = $model;
    }

    public function import(array $data)
    {
        DB::beginTransaction();

        try {

            if (!Storage::exists('uploads')) {
                Storage::makeDirectory('uploads');
            }

            $fileName    = $data['file']->getClientOriginalName();
            $fileHistory = FileHistory::create(['name' => $fileName]);

            // Processar o arquivo diretamente
            $job = new ImportFileJob($data['file'], $fileHistory);
            $job->handle(); // Executa o job diretamente

            DB::commit();

        }  catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            // Verifica se o erro é de violação de unicidade
            if ($e->getCode() === '23000') { // Código SQLSTATE para violação de restrição
                $errorMessage = 'O arquivo com o nome "' . $data['file']->getClientOriginalName() . '" já foi importado.';
            } else {
                $errorMessage = 'Erro ao importar o arquivo: ' . $e->getMessage();
            }

            Log::error($errorMessage, [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new \Exception($errorMessage);
        } catch (\Throwable $th) {

            DB::rollBack();

            Log::error('Erro ao importar arquivo', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            throw $th;
        }
    }

    public function getList(array $data)
    {
        try {

            $tckrSymb   = $data['tckr_symb'] ?? null;
            $rptDt      = $data['rpt_dt'] ?? null;
            $query      = FileData::query();
        
            if (filled($tckrSymb)) {
                $query->where('tckr_symb', $tckrSymb);
            }

            if (filled($rptDt)) {
                $query->whereDate('rpt_dt', $rptDt);
            }

            $fileData = $query->paginate(10);

            return compact('fileData', 'tckrSymb', 'rptDt');

        } catch (\Throwable $th) {

            Log::error('Erro ao listar/filtrar dados', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            throw $th;
        }
    }
}