<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileDataCreateRequest;
use App\Http\Requests\FileDataFilterRequest;
use App\Services\FileDataService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class FileDataController extends Controller
{
    public function __construct(
        private FileDataService $fileDataService
    ) {}

    public function index(): \Illuminate\View\View
    {
        return view('file-data.home.index');
    }

    public function import(FileDataCreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {

            $this->fileDataService->importData($request->validated());

            return back()->with('success', 'Arquivo importado com sucesso!');

        } catch (QueryException $e) {

            return $this->handleQueryException($e);

        } catch (\Exception $e) {

            return $this->handleGenericException($e);

        }
    }

    public function getList(FileDataFilterRequest $request): \Illuminate\View\View
    {
        try {

            $result = $this->fileDataService->getList($request->validated());

            return view('file-data.filter.index', $result);

        } catch (\Exception $e) {

            Log::error('Erro ao listar/filtrar os dados', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return view('file-data.filter.index')
                    ->with('error', 'Ocorreu um erro ao listar/filtrar os dados. Por favor, tente novamente.');
        }
    }

    private function handleQueryException(QueryException $e): \Illuminate\Http\RedirectResponse
    {
        Log::error('Erro de banco de dados durante a importação', [
            'error' => $e->getMessage(),
            'code' => $e->getCode(),
        ]);

        if ($e->getCode() === '23000') {

            $errorMessage = match (true) {
                str_contains($e->getMessage(), 'Duplicate entry') => 'Um arquivo com este nome já foi importado.',
                str_contains($e->getMessage(), 'cannot be null') => 'Erro ao importar: valores obrigatórios estão ausentes no arquivo.',
                default => 'Erro desconhecido ao importar o arquivo.',
            };

            return back()->with('error', $errorMessage);

        }

        return back()->with('error', 'Erro de banco de dados desconhecido.');
    }

    private function handleGenericException(\Exception $e): \Illuminate\Http\RedirectResponse
    {
        Log::error('Erro genérico durante a importação', [
            'error' => $e->getMessage(),
        ]);

        return back()->with('error', $e->getMessage());
    }
}