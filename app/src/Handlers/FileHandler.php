<?php

namespace App\Handlers;

class FileHandler
{
    private array $errors = [];
    private array $uploadedFiles = [];
    private int $maxCount;
    private ?int $maxFileSize = 10240;
    private ?string $mimeType;

    public function __construct($maxCount = 1, $mimeType = null)
    {
        $this->maxCount = $maxCount;
        $this->mimeType = $mimeType;
    }

    public function validate(array $files, bool $save = false, ?string $uploadDir = null): bool
    {
        if (count($files['name']) > $this->maxCount) {
            $this->addError([
                'type' => 'danger',
                'message' => 'Nahráli jste více než ' . $this->maxCount . ' soubory.',
            ]);
            return false;
        } elseif (count($files['name']) < 2) {
            $this->addError([
                'type' => 'danger',
                'message' => 'Nahráli jste méně než ' . $this->maxCount . ' soubory.',
            ]);
            return false;
        }

        for ($i = 0; $i < count($files['name']); $i++) {
            $fileName = $files['name'][$i];
            $fileTmpName = $files['tmp_name'][$i];
            $fileSize = $files['size'][$i];
            $fileError = $files['error'][$i];
            $fileType = $files['type'][$i];

            if ($fileType !== $this->mimeType) {
                $this->addError([
                    'type' => 'danger',
                    'message' => 'Soubor ' . $fileName . ' je v nesprávném formátu, podporované formáty: ' . $this->mimeType,
                ]);
                return false;
            } elseif ($fileType == $this->mimeType && $fileType == 'text/csv') {
                $isValid = CsvHandler::validateCsv($files['tmp_name'][$i]);
                if (!$isValid) {
                    $this->addError([
                        'type' => 'danger',
                        'message' => 'Soubor ' . $fileName . ' neobsahuje správné sloupce.',
                    ]);
                    return false;
                }
            } elseif (!is_null($this->maxFileSize) && $fileSize > $this->maxFileSize) {
                $this->addError([
                    'type' => 'danger',
                    'message' => 'Soubor ' . $fileName . ' přesahuje maximální povolenou velikost (' . $this->maxFileSize / 1024 . 'MB)',
                ]);
                return false;
            }

            if ($fileError === UPLOAD_ERR_OK) {
                if ($save && !is_null($uploadDir)) {
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $uploadFilePath = $uploadDir . uniqid() . '_' . basename($fileName);

                    if (!move_uploaded_file($fileTmpName, $uploadFilePath)) {
                        $this->addError([
                            'type' => 'danger',
                            'message' => 'Chyba při nahrávání souboru ' . $fileName,
                        ]);
                    } else {
                        $this->addUploadedFile($uploadFilePath);
                    }
                }
            } else {
                $this->addError([
                    'type' => 'danger',
                    'message' => 'Chyba při nahrávání souboru ' . $fileName,
                ]);
                return false;
            }
        }

        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function addError(array $error): self
    {
        $this->errors[] = $error;
        return $this;
    }

    public function getUploadedFiles(): array
    {
        return $this->uploadedFiles;
    }

    private function addUploadedFile(string $filePath): self
    {
        $this->uploadedFiles[] = $filePath;
        return $this;
    }
}
