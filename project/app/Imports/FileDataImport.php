<?php

namespace App\Imports;

use App\Models\FileData;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FileDataImport implements OnEachRow, WithChunkReading
{
    private $fileHistoryId;
    private $dataToInsert = [];
    private $batchSize = 7500; // Tamanho do lote para inserção

    public function __construct($fileHistoryId)
    {
        $this->fileHistoryId = $fileHistoryId;
    }

    public function onRow(Row $row)
    {
        $rowData = $row->toArray();

        $this->dataToInsert[] = [
            'rpt_dt'            => $rowData['RptDt'] ?? null,
            'tckr_symb'         => $rowData['TckrSymb'] ?? null,
            'mkt_nm'            => $rowData['MktNm'] ?? null,
            'scty_ctgy_nm'      => $rowData['SctyCtgyNm'] ?? null,
            'isin'              => $rowData['ISIN'] ?? null,
            'crpn_mm'           => $rowData['CrpnNm'] ?? null,
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
