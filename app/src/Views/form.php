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
        <div class="row">
            <div class="col-md-12">
                <?php if (isset($alerts) && count($alerts) > 0) { ?>
                    <?php foreach ($alerts as $alert) { ?>
                        <?php if (array_key_exists('type', $alert) && array_key_exists('message', $alert)) { ?>
                            <div class="alert alert-<?= $alert['type']; ?>" role="alert">
                                <?= $alert['message']; ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <form action="/form/submit" method="POST" enctype="multipart/form-data" class="form-upload card rounded-7 me-lg-n5 p-5">
                    <div class="mb-3">
                        <h1 class="text-wrap">
                            Formulář pro zpracování dat z Oskarů
                        </h1>
                        <p>
                            Nahrajte prosím dva soubory ve formátu CSV, které budou obsahovat tyto sloupce: <b>Index, Year, Age, Name, Movie</b>
                        </p>
                    </div>

                    <div class="mb-3">
                        <input class="form-control" type="file" name="uploaded_files[]" id="formFileMultiple" multiple>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="form-control">
                            Odeslat formulář
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>