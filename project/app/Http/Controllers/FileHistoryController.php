<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileHistoryFilterRequest;
use App\Services\FileHistoryService;

class FileHistoryController extends Controller
{
    private $fileHistoryService;

    public function __construct(FileHistoryService $fileHistoryService)
    {
        $this->fileHistoryService = $fileHistoryService;
    }

    public function index(FileHistoryFilterRequest $request)
    {
        $result = $this->fileHistoryService->getList($request->validated());

        return view('file-history.home.index', $result);
    }
}
