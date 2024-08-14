<?php

namespace App\Controllers;

use App\Handlers\CsvHandler;
use App\Handlers\FileHandler;

class FormController extends BaseController
{
    public function index(): void
    {
        $this->render('form');
    }

    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['uploaded_files'])) {
                $files = $_FILES['uploaded_files'];

                $fileHandler = new FileHandler(2, 'text/csv');
                $uploadPath = PUBLIC_DIR . '/uploads/';
                $validationResult = $fileHandler->validate($files, true, $uploadPath);

                if (!$validationResult) {
                    $this->render('form', ['alerts' => $fileHandler->getErrors()]);
                } elseif (count($fileHandler->getUploadedFiles()) == 2) {
                    $csvHandler = new CsvHandler($fileHandler->getUploadedFiles());
                    $tables = $csvHandler->getAwardsByYear();
                    $this->render('oscars_overview', ['awardsByYear' => $csvHandler->getAwardsByYear(), 'moviesWithBothAwards' => $csvHandler->getMoviesWithBothAwards()]);
                }
            } else {
                $this->render('form', [
                    'alerts' => [
                        [
                            'type' => 'danger',
                            'message' => 'Došlo k chybě při nahrávání souborů, zkuste to prosím znovu.',
                        ]
                    ]
                ]);
            }
        }
    }
}
