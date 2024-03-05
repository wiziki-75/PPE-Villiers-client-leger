<form method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Nom</label>
        <input value="<?= $data['nom'] ?>" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Prénom</label>
        <input value="<?= $data['prenom'] ?>" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input value="<?= $data['courriel'] ?>" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Nouveau mot de passe</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Confirmation du mot de passe</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password2">
    </div>
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>