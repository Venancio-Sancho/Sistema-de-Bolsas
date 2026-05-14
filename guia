
GUIÃO DE INSTALAÇÃO E UTILIZAÇÃO DO SISTEMA DE BOLSAS

Este guião explica, de forma simples e organizada, como instalar, configurar e utilizar o Sistema de Candidatura de Bolsas.

1. REQUISITOS DO SISTEMA
• PHP
• Composer
• Node.js e NPM
• MySQL
• XAMPP

2. INSTALAÇÃO DAS DEPENDÊNCIAS
• composer install
• npm install
• php artisan key:generate
• php artisan migrate

3. BIBLIOTECA ADICIONAL E CRIAÇÃO DE LIGAÇÃO PARA FICHEIROS
• barryvdh/laravel-dompdf (gerar e exportar relatórios em PDF)
• php artisan storage:link (Permitte o acesso aos ficheiros guardados em storage/app/public)

4. CRIAÇÃO DO ADMINISTRADOR
• php artisan db:seed (cria as credenciaes para acessar o sistema como administrador)

Email: admin@gmail.com
Senha: 123456

5. FUNCIONALIDADES DO ADMINISTRADOR
• Gerir Faculdades
• Gerir Departamentos
• Gerir Cursos
• Gerir Bolsas
• Gerir Utilizadores
• Gerir Candidaturas
• Consultar Resultados
• Gerar Relatórios em PDF
• Mandar Mensagens para todos os estudantes cadastrados
• Ver Notificações

6. FUNCIONALIDADES DO ESTUDANTE

Nota: Antes de os estudantes criarem conta, o administrador deve cadastrar primeiro as faculdades, departamentos e cursos. Estes dados aparecem como opções no formulário de registo do estudante.

• Ver painel do estudante
• Consultar bolsas disponíveis
• Submeter candidatura
• Enviar documentos
• Acompanhar candidatura
• Receber notificações
• Enviar mensagens para o administrador

7. FORMATOS ACEITES
• PDF
• JPG
• PNG
• Máximo: 2 MB por ficheiro

8. RECUPERAÇÃO DE SENHA
• Usar a opção Recuperar Senha na tela de login.
• Configurar correctamente MAIL_* no ficheiro .env.

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seuemail@gmail.com (seu email)
MAIL_PASSWORD=sua_senha_app (colocar senha gerada pelo app no gmail)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seuemail@gmail.com (seu email)
MAIL_FROM_NAME="app" (no nome do app que vai gerar a senha)
