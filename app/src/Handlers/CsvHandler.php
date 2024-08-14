<?php

namespace App\Handlers;

use App\Models\OscarAward;

class CsvHandler
{
    private array $files;
    private array $oscarAwards = [];

    public function __construct(array $files)
    {
        $this->files = $files;

        if (empty($this->getOscarAwards())) {
            $this->createAwards();
        }
    }

    public static function validateCsv(string $filePath, $expectedColumns = ["Index", "Year", "Age", "Name", "Movie"]): bool
    {
        $result = false;
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            $header = fgetcsv($handle);
            $result = $header === $expectedColumns;
            fclose($handle);
        }

        return $result;
    }

    public function getAwardsByYear(): array
    {
        $awardsByYear = [];

        /** @var OscarAward $award */
        foreach ($this->getOscarAwards() as $key => $award) {
            $gender = $award->isFemale() ? 'female' : 'male';
            $awardsByYear[$award->getYear()][$gender][$key]['name'] = $award->getName() . ' (' . $award->getAge() . ')';
            $awardsByYear[$award->getYear()][$gender][$key]['movie'] = $award->getMovie();
        }

        return $awardsByYear;
    }

    public function getMoviesWithBothAwards(): array
    {

        $moviesWithBothAwards = [];

        /** @var OscarAward $award */

        foreach ($this->getOscarAwards() as $award) {
            $movie = $award->getMovie();
            $isFemale = $award->isFemale();

            if (!isset($moviesWithBothAwards[$movie])) {
                $moviesWithBothAwards[$movie] = ['male' => false, 'female' => false];
                $moviesWithBothAwards[$movie]['year'] = $award->getYear();
            }

            if ($isFemale) {
                $moviesWithBothAwards[$movie]['female'] = true;
                $moviesWithBothAwards[$movie]['femaleName'] = $award->getName();
            } else {
                $moviesWithBothAwards[$movie]['male'] = true;
                $moviesWithBothAwards[$movie]['maleName'] = $award->getName();
            }
        }
        ksort($moviesWithBothAwards, SORT_STRING);

        return array_filter($moviesWithBothAwards, function ($genderArray) {
            return $genderArray['male'] && $genderArray['female'];
        });
    }

    public function createAwards(): void
    {
        foreach ($this->files as $filePath) {
            if ((file_exists($filePath) && $handle = fopen($filePath, "r")) !== FALSE) {
                $header = fgetcsv($handle);
                $columnsCount = count($header);
                $isFemale = str_contains($filePath, '_female');


                while ($row = fgetcsv($handle)) {
                    if (count($row) == $columnsCount) {
                        foreach ($row as $columnName => $data) {
                            $row[$columnName] = trim($data);
                        }

                        $award = new OscarAward(array_combine($header, $row), $isFemale);
                        $this->addOscarAward($award);
                    }
                }
                fclose($handle);
            }
        }
    }

    private function addOscarAward(OscarAward $oscarAward): self
    {
        $this->oscarAwards[] = $oscarAward;
        return $this;
    }

    private function getOscarAwards(): array
    {
        return $this->oscarAwards;
    }
}
