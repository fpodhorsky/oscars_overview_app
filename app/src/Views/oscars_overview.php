<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oscars overview app</title>
    <link rel="stylesheet" href="/style.css" class="style">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-secondary">
    <div class="container centered-container d-flex justify-content-center align-items-center">
        <div class="row d-flex justify-content-center align-items-center text-center">
            <h1 class="text-center mt-5 mb-1">
                Přehled dat z Vámi nahraných souborů
            </h1>
            <?php if (isset($awardsByYear) && !empty($awardsByYear)) { ?>
                <h2 class="text-center mt-3">
                    Tabulka s přehledem oscarů podle roku
                </h2>
                <div class="rounded bg-white">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Rok</th>
                                <th scope="col">Ženy</th>
                                <th scope="col">Muži</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($awardsByYear as $year => $awarded) { ?>
                                <tr>
                                    <td><?= $year ?></td>
                                    <td>
                                        <?php foreach ($awarded['female'] as $female) { ?>
                                            <b>
                                                <?= $female['name'] ?>
                                            </b>
                                            <br>
                                            <?= $female['movie'] ?>
                                            <br>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php foreach ($awarded['male'] as $male) { ?>
                                            <b>
                                                <?= $male['name'] ?>
                                            </b>
                                            <br>
                                            <?= $male['movie'] ?>
                                            <br>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>

            <?php if (isset($moviesWithBothAwards) && !empty($moviesWithBothAwards)) { ?>
                <h2 class="text-center mt-5">
                    Tabulka se seznamem filmů, které obdržely oscary za mužskou i ženskou hlavní roli
                </h2>
                <div class="rounded bg-white">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Název filmu</th>
                                <th scope="col">Rok</th>
                                <th scope="col">Herečka</th>
                                <th scope="col">Herec</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($moviesWithBothAwards as $movie => $movieData) { ?>
                                <tr>
                                    <td><?= $movie ?></td>
                                    <td><?= $movieData['year'] ?></td>
                                    <td>
                                        <b>
                                            <?= $movieData['femaleName'] ?>
                                        </b>
                                    </td>
                                    <td>
                                        <b>
                                            <?= $movieData['maleName'] ?>
                                        </b>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            <?php } ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>