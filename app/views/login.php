<br><br>
<div class="container high"><div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <h1>Logowanie</h1>
            </div>
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3"><div class="alert alert-info">
                <strong>Info!</strong> Wypełnij formularz aby się zalogować. Przykładowy username: <b>pat@beat.com</b> password: <b>wert1234</b>
                </div></div>
<?php if(isset($message) && !empty($message)): ?>
<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
    <div class="alert alert-danger">
        <img src="assets/home.png" width="100px" alt="">
        <?= $message ?>
        <br>
</div></div>
<?php endif; ?>
<form action="/login" method='post'>
    <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
        <label for='lname'>Login/e-mail:</label><br>
        <input class='form-control' type='email' name='username' id='lname' ><br>
    </div>
    <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
        <label for='password'>Hasło:</label><br>
        <input class='form-control' type='password' name='password' id='password' ><br>
    </div>
    <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
        <input class='btn stretch' type='submit'  name='submit' value='Logowanie'>
    </div>
</form>