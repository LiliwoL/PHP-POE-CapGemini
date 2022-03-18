<?php require( __ROOT__ . 'templates/_header.php'); ?>

<h1>La liste des stagiaires</h1>
<table class="table">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Nom</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($stagiaires as $stagaire): ?>
            <tr>
                <th scope="row">
                    <?= htmlentities($stagaire->getIdentifiant()); ?>
                </th>
                <td>
                    <?= htmlentities($stagaire->getNom()); ?>
                </td>
            </tr>
        <?php endforeach; ?>
  </tbody>
</table>
<?php require( __ROOT__ . 'templates/_footer.php'); ?>