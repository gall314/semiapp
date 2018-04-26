<h1>Strona po zalogowaniu</h1>
<?php $role = $_SESSION['role']; ?>

<?php if($role == 'admin'): ?>
Strefa dla admnistratora
<?php endif; ?>
