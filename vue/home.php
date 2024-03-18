<?php
$evenements = $unControleur->selectAllEvenement();
?>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            foreach ($evenements as $evenement) {
            ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <?php
                        switch($evenement['type']){
                            case 'Concert':
                                $img = "vue/images/concert.jpg";
                                break;
                            case 'Educatif':
                                $img = "vue/images/educatif.png";
                                break;
                            case 'Communautaire':
                                $img = "vue/images/communautaire.jpg";
                                break;
                        }
                        ?>
                        <img class="card-img-top" src="<?= $img ?>" width="200" height="160"/>
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder"><?= $evenement['nom'] ?></h5>
                                <?= $evenement['date'] ?>
                            </div>
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">

                                <?php
                                if ($evenement['statut'] === "confirmé") {
                                    $url = "index.php?page=inscriptionEvent&evenement=" . $evenement['idEvenement'];
                                    if (isset($_SESSION['email'])) {
                                        $participation = $unControleur->checkParticipation($_SESSION['id'], $evenement['idEvenement']);
                                        if ($participation) {
                                ?>
                                            <button type="button" class="btn btn-success" disabled>Inscris</button>
                                        <?php
                                        } else {
                                            $url .= "&id=" . $_SESSION['id'];
                                        ?>
                                            <a class="btn btn-outline-dark mt-auto" href="<?= htmlspecialchars($url) ?>">S'inscrire</a>
                                <?php
                                        }
                                    }
                                } else {
                                    echo $evenement['statut'];
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>