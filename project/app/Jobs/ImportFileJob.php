<?php

namespace App\Jobs;

use App\Imports\FileDataImport;
use App\Models\FileData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;
use League\Csv\SyntaxError;
use Maatwebsite\Excel\Facades\Excel;

class ImportFileJob implements ShouldQueue
{
    use Queueable;

    protected $file;
    protected $fileHistory;

    /**
     * Create a new job instance.
     */
    public function __construct($file, $fileHistory)
    {
        $this->file = $file;
        $this->fileHistory = $fileHistory;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $extension = $this->file->getClientOriginalExtension();

        if (in_array($extension, ['xls', 'xlsx'])) { 
            $this->importXlsx();
        } else {
            $this->importCsv();
        }

    }

    private function importCsv()
    {
        try {
            $path = $this->file->storeAs('uploads', $this->file->getClientOriginalName());

            $csv = Reader::createFromPath(storage_path('app/private/' . $path), 'r');
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

        } catch (\Exception $e) {

            Log::error('Erro ao processar o arquivo: ' . $e->getMessage());

            throw new \Exception('Erro ao processar o arquivo: ' . $e->getMessage());
            
        } catch (SyntaxError $e) {

            Log::error('Erro ao processar o arquivo CSV: ' . $e->getMessage());

            throw new \Exception('O arquivo CSV contém colunas duplicadas no cabeçalho. Por favor, corrija o arquivo e tente novamente.');

        } catch (\Throwable $th) {

            Log::error('Erro inesperado: ' . $th->getMessage());

            throw $th;

        }
    }

    private function importXlsx()
    {
        try {
            $result = Excel::import(new FileDataImport($this->fileHistory->id), $this->file);

            Log::info('Importação XLS/XLSX concluída.', ['result' => $result]);

            return $result;
        } catch (\Throwable $th) {
            Log::error('Erro ao importar arquivo XLS/XLSX: ' . $th->getMessage());
            throw $th;
        }
    }
}
