<?php 
    /* Template Name: OAA Custom Login Page */ 
?>

<?php get_header(); ?>

<section class="oaa-container">
    <div class="oaa-login-holder">
        <form method="POST" class="oaa-login-form" oaa-login-form>
            <label for="oaa-form-email">
                <p>E-mail</p>
                <input type="email" name="oaa-form-email" id="oaa-form-email" placeholder="email@email.com">
            </label>

            <label for="oaa-form-password">
                <p>Senha</p>
                <input type="password" name="oaa-form-password" id="oaa-form-password" autocomplete="on" placeholder="Senha">
            </label>

            <button type="submit">
                <p>Entrar</p>
                <div class="oaa-loading" oaa-form-loading>
                    <i class="fas fa-spinner"></i>
                </div>
            </button>
            <a href="/cadastro">Cadastre-se</a>
        </form>

        <div class="oaa-login-holder__message" oaa-login-form-message-box>
        </div>
    </div>
</section>

<?php get_footer(); ?>