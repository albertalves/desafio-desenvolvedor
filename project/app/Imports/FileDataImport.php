<?php

namespace App\Imports;

use App\Models\FileData;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FileDataImport implements OnEachRow, WithChunkReading
{
    private $dataToInsert = [];
    private $batchSize = 7500; // Tamanho do lote para inserção
    private $isFirstRow = true; // Variável para rastrear a primeira linha

    public function __construct(
        private $fileHistoryId
    ) {}

    public function onRow(Row $row)
    {
        // Ignorar a primeira linha (cabeçalho)
        if ($this->isFirstRow) {
            $this->isFirstRow = false;
            return;
        }

        $rowData = $row->toArray();

        $this->dataToInsert[] = [
            'rpt_dt'            => $rowData[0],
            'tckr_symb'         => $rowData[1],
            'mkt_nm'            => $rowData[5],
            'scty_ctgy_nm'      => $rowData[6],
            'isin'              => $rowData[15],
            'crpn_mm'           => $rowData[47],
            'file_history_id'   => $this->fileHistoryId,
        ];

        if (count($this->dataToInsert) >= $this->batchSize) {
            FileData::insert($this->dataToInsert);
            $this->dataToInsert = [];
        }
    }

    public function chunkSize(): int
    {
        return 7500;
    }

    public function __destruct()
    {
        if (!empty($this->dataToInsert)) {
            FileData::insert($this->dataToInsert);
        }
    }
}
