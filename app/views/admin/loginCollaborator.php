<form action="/admin/login/store" method="post">
    <label for="">Email</label>
    <input type="text" name="email">
    <hr>
    <label for="">Senha</label>
    <input type="text" name="password">
    <?php echo flash('loginCollaborator');?>
    <?php echo flash('passwordLoginCollaborator');?>
    <hr>
    <input type="submit" value="entrar">
</form>