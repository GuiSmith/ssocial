<?php require "src/back/config.php" ?>

<!DOCTYPE html>
<html lang="en">
    <?php require "src/front/head.php" ?>
    <body>
        <?php require "src/front/navbar.php" ?>
        <div id='error-message' style='padding: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px;font-size:25px'>
            <h2 style='margin-top: 0;'>Erro: Banco de Dados Somente Leitura</h2>
            <p>Desculpe, não foi possível salvar seus dados. O banco de dados está em modo somente leitura.</p>
            <p>Possível solução:</p>
            <p>Ajuste as permissões do diretório <code>/var/www/html/projects/ssocial</code> no terminal:</p>
            <pre><code>cd /var/www/html/projects/
        sudo chmod 777 -R ssocial</code></pre>
            <p>Após isso, curta uma postagem para tentar novamente.</p>

            <p>Se o problema persistir, entre em contato:</p>
            <div style="margin-bottom: 10px;">
                <!-- Botão WhatsApp -->
                <a href="https://wa.me/5549991116100" target="_blank" style="display: inline-block; background-color: #25D366; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-right: 10px;">
                    Contatar via WhatsApp
                </a>
                <!-- Botão Portfólio -->
                <a href="https://guismith.github.io/portfolio" target="_blank" style="display: inline-block; background-color: #007BFF; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-right: 10px;">
                    Meu Portfólio
                </a>
                <!-- Botão E-mail -->
                <a href="mailto:guilhermessmith2014@gmail.com" style="display: inline-block; background-color: #DC3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Enviar E-mail
                </a>
            </div>
        </div>
        <?php echo $php_errormsg; ?>
    </body>
</html>