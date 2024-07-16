<?php
    require "../src/back/config.php";
?>

<!DOCTYPE html>
<html lang="en">
    <?php require SRC_URL."front/head.php" ?>
    <body>
        <?php require SRC_URL."front/navbar.php" ?>

        <h1 class="text-center">Atividade Final do DevEvolution PHP 2024</h1>
        <h4 class="text-center"><strong>Desenvolvimento de uma Rede Social</strong></h4>

        <div class="container mt-5">
            <p>Desenvolva uma rede social básica que permita aos usuários se registrar, fazer login, criar posts, curtir posts e seguir outros usuários. O sistema deve ser desenvolvido usando PHP, SQLite e sessões HTTP.</p>
            <p>É necessário utilizar todos os aprendizados adquiridos em sala para a resolução desta atividade.</p>
            
            <h2>Requisitos</h2>
            <h3>Banco de Dados SQLite</h3>
            <ul>
                <li>Tabelas: Crie as tabelas <code>usuarios</code>, <code>posts</code>, <code>curtidas</code> e <code>seguidores</code> (os nomes podem ser ajustados conforme necessário).</li>
                <li>Estrutura das Tabelas: Defina a estrutura das tabelas de acordo com os requisitos abaixo, garantindo que os dados necessários sejam armazenados corretamente.</li>
            </ul>

            <h3>Autenticação de Usuário</h3>
            <ul>
                <li>Crie uma página para que novos usuários possam se cadastrar.</li>
                <li>Permita que os usuários façam login após o cadastro, utilizando email e senha.</li>
                <li>Utilize sessões PHP para manter os usuários autenticados.</li>
                <li>Garanta que apenas usuários autenticados possam criar posts e curtir posts.</li>
            </ul>

            <h3>Postagem</h3>
            <ul>
                <li>Crie uma página que mostre todos os posts feitos na rede social, ordenados pela data de criação, do mais novo para o mais velho.</li>
                <li>Permita que os usuários façam novas postagens com até 100 caracteres.</li>
            </ul>

            <h3>Curtidas</h3>
            <ul>
                <li>Permita que os usuários curtam as postagens de outros usuários.</li>
                <li>Mostre o total de curtidas de cada postagem no feed principal.</li>
            </ul>

            <h3>Perfil</h3>
            <ul>
                <li>Permita que os usuários visitem o perfil de outros usuários.</li>
                <li>Ao visitar um perfil, mostre os dados do usuário e suas postagens, similar ao feed principal.</li>
                <li>Contabilize e mostre o número de visitas ao perfil.</li>
                <li>Mostre o total de seguidores.</li>
                <li>Permita que os usuários autenticados editem seu próprio perfil.</li>
                <li>Ofereça a opção de deletar a conta: ao deletar a conta, exclua todos os posts, curtidas e informações do usuário, e deslogue da rede.</li>
            </ul>

            <h3>Controle de Seguidores</h3>
            <ul>
                <li>Permita que os usuários sigam e deixem de seguir outros usuários.</li>
                <li>A interface visual fica a critério de vocês; podem fazer o básico ou utilizar algo pronto, como Bootstrap.</li>
            </ul>

            <h3>Funcionalidades opcionais</h3>
            <p>Se você conseguiu realizar a atividade em pouco tempo, deixarei mais alguns desafios que são opcionais:</p>

            <h4>Postagem</h4>
            <ul>
                <li>Adicione a funcionalidade de anexar uma imagem a um post. As imagens devem ser armazenadas no servidor, e o caminho da imagem deve ser salvo no banco de dados.</li>
            </ul>

            <h4>Curtidas</h4>
            <ul>
                <li>Permita que os usuários descurtam os posts que já curtiram.</li>
            </ul>

            <h4>Perfil</h4>
            <ul>
                <li>Adicione uma funcionalidade de biografia para que os usuários possam adicionar uma descrição sobre si mesmos.</li>
            </ul>

            <h3>Avaliação</h3>
            <p>A avaliação consistirá no atendimento aos requisitos obrigatórios. Será levado em consideração a lógica de resolução, a organização do código, a estrutura do banco de dados e, claro, o pleno funcionamento do sistema.</p>
            <p>As funcionalidades opcionais não contarão pontos adicionais, mas demonstrarão seu interesse e capacidade lógica para resolução de problemas.</p>
        </div>

        <!-- Imagens usadas -->
        <div class = "text-center">
            <h2>Imagens usadas</h2>
        </div>
        <section class = "container" >
            Ícone do site: Image by <a href="https://pixabay.com/users/mohamed_hassan-5229782/?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=5508549">Mohamed Hassan</a> from <a href="https://pixabay.com//?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=5508549">Pixabay</a>
        </section>
    </body>
</html>

