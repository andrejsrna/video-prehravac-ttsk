<div class="container">
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post" action="" id="login_form">
        <h1>Prihláste sa</h1>
        <input type="password" name="pass">
        <input type="submit" name="submit_pass" value="Prihlásiť sa">
    </form>
</div>
