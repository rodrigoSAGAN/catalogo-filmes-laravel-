# Teste de Sistema - Catálogo de Filmes

## Título do Teste
**Fluxo Completo: Login e Adição de Novo Filme ao Catálogo**

## Objetivo
Validar o fluxo completo de um usuário autenticado ao criar e adicionar um novo filme ao catálogo pessoal, verificando a integração entre autenticação, formulários, persistência de dados e exibição.

---

## Pré-requisitos

### Ambiente
- Aplicação Laravel rodando localmente (`php artisan serve`)
- Banco de dados configurado e com migrações executadas
- Navegador web moderno (Chrome, Firefox, Edge)

### Dados de Teste
- **Usuário de Teste:**
  - Email: `teste@exemplo.com`
  - Senha: `senha123`
  - (Ou qualquer usuário válido cadastrado no sistema)

---

## Sequência de Passos

### Passo 1: Navegar até a Página de Login
1. Abrir o navegador
2. Acessar a URL: `http://localhost:8000/login`
3. **Verificar:** A página de login deve carregar corretamente com os campos de email e senha

### Passo 2: Realizar Login com Credenciais Válidas
1. No campo "Email", inserir: `teste@exemplo.com`
2. No campo "Senha", inserir: `senha123`
3. Clicar no botão "Entrar" ou "Login"
4. **Verificar:** O usuário deve ser autenticado e redirecionado para o dashboard ou página inicial

### Passo 3: Navegar para a Listagem de Filmes
1. Clicar no menu de navegação em "Filmes" ou "Meus Filmes"
   - Ou acessar diretamente: `http://localhost:8000/filmes`
2. **Verificar:** A página de listagem de filmes deve carregar, exibindo o catálogo pessoal (pode estar vazio ou conter filmes existentes)

### Passo 4: Clicar no Botão "Adicionar Filme"
1. Localizar o botão "Adicionar Filme" no topo da página
2. Clicar no botão
3. **Verificar:** O usuário deve ser redirecionado para o formulário de criação de filme (`/filmes/adicionar`)

### Passo 5: Preencher o Formulário de Criação
Preencher todos os campos obrigatórios e opcionais com os seguintes dados de teste:

| Campo | Valor de Teste |
|-------|----------------|
| **Título*** | `Inception` |
| **Ano de Lançamento*** | `2010` |
| **Gênero*** | `Ação` (selecionar do dropdown) |
| **Autor (Diretor/Escritor)** | `Christopher Nolan` |
| **É uma Série?** | Deixar desmarcado (não) |
| **Avaliação (IMDb/Rotten)** | `8.8` |
| **URL da Imagem** | `https://example.com/inception.jpg` |
| **Comentário Pessoal** | `Um filme incrível sobre sonhos e realidade.` |
| **Sua Avaliação (1-5)** | `5` |

**Campos marcados com * são obrigatórios*

### Passo 6: Salvar o Novo Filme
1. Após preencher todos os campos, clicar no botão "Adicionar Filme" ou "Salvar"
2. **Verificar:** 
   - O formulário é submetido sem erros de validação
   - O usuário é redirecionado para a listagem de filmes

### Passo 7: Verificar a Exibição do Novo Filme na Lista
1. Na página de listagem (`/filmes`), localizar o filme recém-criado
2. **Verificar:**
   - O filme "Inception" aparece na lista
   - As informações são exibidas corretamente:
     - Título: "Inception"
     - Ano: "2010"
     - Gênero: "Ação"
     - Avaliação visível (se aplicável)

### Passo 8 (Opcional): Validar Filtro por Gênero
1. Localizar o filtro de gênero na página de listagem
2. Selecionar "Ação" no dropdown de gênero
3. **Verificar:**
   - A página é atualizada/filtrada
   - O filme "Inception" aparece na lista filtrada
   - Filmes de outros gêneros não aparecem (se houver)

### Passo 9 (Opcional): Validar Busca por Autor
1. Localizar o campo de busca por autor
2. Digitar "Christopher Nolan" e clicar em buscar
3. **Verificar:**
   - O filme "Inception" aparece nos resultados
   - A busca funciona corretamente com o nome do autor

---

## Resultado Esperado

### Critérios de Sucesso
✅ O usuário consegue fazer login com sucesso  
✅ O formulário de criação é acessível e renderiza corretamente  
✅ Todos os campos do formulário aceitam entrada de dados  
✅ O dropdown de gênero exibe as opções predefinidas (Terror, Drama, Comédia, Ação, Aventura, Infantil, Romântico)  
✅ O formulário é submetido sem erros  
✅ O usuário é redirecionado para `/filmes` após o salvamento  
✅ O novo filme aparece na listagem com todas as informações corretas  
✅ O filtro por gênero funciona e exibe o filme criado  
✅ A busca por autor funciona e encontra o filme  

### Comportamento da Interface
- **Estilo Visual:** Dark mode com tema roxo/violeta
- **Responsividade:** Interface deve funcionar em diferentes tamanhos de tela
- **Feedback:** Mensagens de sucesso/erro devem ser claras
- **Navegação:** Botões e links funcionam conforme esperado

---

## Casos de Falha Conhecidos

### Cenário: Campos Obrigatórios Vazios
- **Ação:** Tentar salvar o formulário sem preencher título, ano ou gênero
- **Resultado Esperado:** Mensagens de validação devem aparecer indicando os campos obrigatórios

### Cenário: Dados Inválidos
- **Ação:** Inserir ano com mais de 4 dígitos ou avaliação fora do range
- **Resultado Esperado:** Validação deve impedir o salvamento e mostrar mensagens de erro

### Cenário: Usuário Não Autenticado
- **Ação:** Tentar acessar `/filmes/adicionar` sem estar logado
- **Resultado Esperado:** Usuário deve ser redirecionado para a página de login

---

## Observações Adicionais

### Pontos de Atenção
- O campo "Autor" é **opcional** (nullable) - o filme pode ser criado sem este campo
- A URL da imagem é **opcional** - se omitida, uma imagem padrão é aplicada automaticamente
- O sistema mantém a ordem de inserção dos filmes (sort_order)
- Todos os filmes pertencem ao usuário autenticado

### Tempo Estimado de Execução
**5-7 minutos** para execução completa do teste manual

### Data de Criação do Teste
04 de Dezembro de 2024

### Versão do Sistema
Laravel 10.x - Catálogo de Filmes v1.0

---

## Registro de Execução

| Data | Testador | Resultado | Observações |
|------|----------|-----------|-------------|
| ___ / ___ / ____ | _____________ | ⬜ PASSOU ⬜ FALHOU | _________________ |
| ___ / ___ / ____ | _____________ | ⬜ PASSOU ⬜ FALHOU | _________________ |
| ___ / ___ / ____ | _____________ | ⬜ PASSOU ⬜ FALHOU | _________________ |
