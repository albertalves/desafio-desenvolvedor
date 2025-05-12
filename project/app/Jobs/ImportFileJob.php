<?php

namespace App\Jobs;

use App\Models\FileData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;
use League\Csv\SyntaxError;

class ImportFileJob implements ShouldQueue
{
    use Queueable;

    protected $filePath;
    protected $fileHistory;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $fileHistory)
    {
        $this->filePath = $filePath;
        $this->fileHistory = $fileHistory;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $csv = Reader::createFromPath(storage_path('app/private/' . $this->filePath), 'r');
            $csv->setDelimiter(',');
            $csv->setHeaderOffset(0);

            $batchSize = 500; // Inserir 500 registros por vez no banco
            $dataToInsert = [];

            // Processar cada registro do CSV
            foreach ($csv->getRecords() as $record) {
                $dataToInsert[] = [
                    'rpt_dt'            => $record['RptDt'] ?? null,
                    'tckr_symb'         => $record['TckrSymb'] ?? null,
                    'mkt_nm'            => $record['MktNm'] ?? null,
                    'scty_ctgy_nm'      => $record['SctyCtgyNm'] ?? null,
                    'isin'              => $record['ISIN'] ?? null,
                    'crpn_mm'           => $record['CrpnNm'] ?? null,
                    'file_history_id'   => $this->fileHistory->id,
                ];

                // Inserir em lotes para evitar sobrecarga de memória
                if (count($dataToInsert) >= $batchSize) {
                    FileData::insert($dataToInsert);
                    $dataToInsert = [];
                }
            }

            // Inserir os registros restantes
            if (!empty($dataToInsert)) {
                FileData::insert($dataToInsert);
            }

        } catch (SyntaxError $e) {

            Log::error('Erro ao processar o arquivo CSV: ' . $e->getMessage());

            throw new \Exception('O arquivo CSV contém colunas duplicadas no cabeçalho. Por favor, corrija o arquivo e tente novamente.');

        } catch (\Throwable $th) {

            Log::error('Erro inesperado: ' . $th->getMessage());

            throw $th;

        }
    }
}
