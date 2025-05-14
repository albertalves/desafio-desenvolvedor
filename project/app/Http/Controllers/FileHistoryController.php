<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileHistoryFilterRequest;
use App\Services\FileHistoryService;

class FileHistoryController extends Controller
{
    public function __construct(
        private FileHistoryService $fileHistoryService
    ) {}

    public function index(FileHistoryFilterRequest $request): \Illuminate\View\View
    {
        $result = $this->fileHistoryService->getList($request->validated());

        return view('file-history.home.index', $result);
    }
}
