<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">

    <div class="row mt-3 d-flex justify-content-center">
        <div class="col-10">
            <h3><?php echo $data['title']; ?></h3>
        </div>
    </div>

    <div class="row mt-3 d-flex justify-content-center" style="display: <?php echo $data['display']; ?>;">
        <div class="col-10">
            <div class="alert alert-success" role="alert">
                <?php echo $data['message']; ?>
            </div>
        </div>
    </div>

    <div class="row mt-3 d-flex justify-content-center">
        <div class="col-10">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Prijs</th>
                        <th>Materiaal</th>
                        <th>Gewicht</th>
                        <th>Releasedatum</th>
                        <th>Verwijder</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['result'] as $sneaker) : ?>
                        <tr>
                            <td><?php echo $sneaker->Merk; ?></td>
                            <td><?php echo $sneaker->Model; ?></td>
                            <td><?php echo $sneaker->Type; ?></td>
                            <td><?php echo $sneaker->Prijs; ?></td>
                            <td><?php echo $sneaker->Materiaal; ?></td>
                            <td><?php echo $sneaker->Gewicht; ?></td>
                            <td><?php echo $sneaker->Releasedatum; ?></td>
                            <td class="text-center">
                                <a href="<?php echo URLROOT; ?>/sneakerController/delete/<?php echo $sneaker->Id; ?>"
                                   onclick="return confirm('Weet je zeker dat je dit record wilt verwijderen?');">
                                    <i class="bi bi-trash3-fill text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="<?php echo URLROOT; ?>/homepages/index" class="btn btn-primary">
                Terug
            </a>

        </div>
    </div>

</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>