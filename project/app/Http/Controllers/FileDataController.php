<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileDataCreateRequest;
use App\Http\Requests\FileDataFilterRequest;
use App\Services\FileDataService;
use Illuminate\Support\Facades\Log;

class FileDataController extends Controller
{
    private $fileDataService;

    public function __construct(FileDataService $fileDataService)
    {
        $this->fileDataService = $fileDataService;
    }

    public function index()
    {
        return view('file-data.home.index');
    }

    public function import(FileDataCreateRequest $request)
    {
        try {
            $this->fileDataService->importData($request->validated());

            return back()->with('success', 'Arquivo importado com sucesso!');

        }  catch (\Illuminate\Database\QueryException $e) {
            
            if ($e->getCode() === '23000') {
                if (str_contains($e->getMessage(), 'Duplicate entry')) {
                    return back()->with('error', 'Um arquivo com este nome já foi importado.');
                }

                if (str_contains($e->getMessage(), 'cannot be null')) {
                    return back()->with('error', 'Erro ao importar: valores obrigatórios estão ausentes no arquivo.');
                }
            }

        } catch (\Throwable $th) {

            return back()->with('error', $th->getMessage());

        }
    }

    public function getList(FileDataFilterRequest $request) 
    {
        try {

            $result = $this->fileDataService->getList($request->validated());

            return view('file-data.filter.index', $result);

        } catch (\Throwable $th) {

            return back()->with('error', 'Ocorreu um erro ao listar/filtrar os dados. Por favor, tente novamente.');

        }
    }
}
