$(document).ready(function() {
  // Inicializa os tooltips
  $('[data-toggle="tooltip"]').tooltip();

  // Gerenciar navegação nas abas (ano e mês)
  $('.nav-link').on('click', function() {
      // Remover a classe 'active' de todas as abas
      $(this).closest('.nav-pills, .nav-tabs').find('.nav-link').removeClass('active');

      // Adicionar a classe 'active' à aba clicada
      $(this).addClass('active');

      // Remover a classe 'show active' de todas as tab panes
      $(this).closest('.nav-pills, .nav-tabs').next('.tab-content').find('.tab-pane').removeClass('show active');

      // Adicionar a classe 'show active' à tab pane correspondente
      const targetId = $(this).attr('href');
      $(targetId).addClass('show active');
  });

  // Função para a paginação de tabelas (carregar conteúdo via AJAX)
  $(document).on('click', '.pagination a, th a', function(event) {
      event.preventDefault();
      $.get($(this).attr('href'), function(response) {
          $('.bancos-index .card-body').html($(response).find('.bancos-index .card-body').html());
          $('[data-toggle="tooltip"]').tooltip(); // Re-inicializa os tooltips após a atualização
      });
  });

  // Confirmar e excluir fatura
  $(document).on('click', '.btn-delete-fatura', function(event) {
      event.preventDefault();  // Impede o comportamento padrão
      if (confirm('Tem certeza que deseja excluir esta fatura?')) {
          fetch(this.href, {
              method: 'POST',
              headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'X-CSRF-Token': yii.getCsrfToken()  // CSRF Token para segurança
              }
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert(data.message);
                  location.reload();  // Atualiza a página após a exclusão
              } else {
                  alert('Ocorreu um erro ao excluir a fatura: ' + data.message);
              }
          })
          .catch(error => {
              console.error('Erro:', error);
              alert('Ocorreu um erro ao processar a solicitação.');
          });
      }
  });

  // Alternar visibilidade das faturas ao clicar nas linhas
  $(document).on('click', '.clickable-row', function() {
      const id = $(this).data('id');
      const detailRow = $('#faturas-' + id);

      // Alterna entre mostrar e esconder as faturas
      detailRow.toggle();  // Utiliza toggle para alternar a visibilidade
  });

  // Copiar fatura (abrir o modal e preencher os dados da fatura)
  $(document).on('click', '.btn-copy-fatura', function(event) {
      event.preventDefault(); // Impede o comportamento padrão

      const faturaId = $(this).data('id'); // Pega o ID da fatura
      // Obtenha a linha da tabela correspondente à fatura
      const linhaFatura = $(this).closest('tr');

      // Extrai os dados da fatura da linha usando data attributes
      const descricao = linhaFatura.find('td[data-descricao]').data('descricao');
      const data = linhaFatura.find('td[data-data]').data('data');
      const valor = linhaFatura.find('td[data-valor]').data('valor');
      const parcelas = linhaFatura.find('td[data-parcelas]').data('parcelas');
      const categoria = linhaFatura.find('td[data-categoria]').data('categoria');

      // Depuração
      console.log('Fatura ID:', faturaId);
      console.log('Descrição:', descricao);
      console.log('Data:', data);
      console.log('Valor:', valor);
      console.log('Parcelas:', parcelas);
      console.log('Categoria:', categoria);

      // Preenche os campos do modal com os dados da fatura
      $('#faturaId').val(faturaId);
      $('#faturaDescricao').val(descricao);
      $('#faturaData').val(data);
      $('#faturaValor').val(valor);
      $('#faturaParcelas').val(parcelas);
      $('#faturaCategoria').val(categoria);
      $('#faturaBanco').val(''); // Limpa a seleção do banco

      // Exibe o modal
      $('#copyFaturaModal').modal('show');
  });

  // Submeter o formulário de cópia da fatura
  $('#copyFaturaForm').on('submit', function(event) {
      event.preventDefault();  // Impede o envio padrão do formulário

      const faturaId = $('#faturaId').val();
      const bancoId = $('#faturaBanco').val();

      if (!bancoId) {
          alert('Por favor, selecione um banco para copiar a fatura.');
          return;
      }

      // Envia os dados para o servidor via AJAX
      $.ajax({
          url: copyFaturaUrl,  // URL da ação no controlador
          type: 'POST',
          data: {
              fatura_id: faturaId,
              banco_id: bancoId,
              _csrf: yii.getCsrfToken()  // Inclui o CSRF Token para segurança
          },
          success: function(response) {
              if (response.success) {
                  alert(response.message);
                  $('#copyFaturaModal').modal('hide');  // Fecha o modal
                  location.reload();  // Recarrega a página para refletir a cópia
              } else {
                  let errorMsg = 'Ocorreu um erro ao copiar a fatura.';
                  if (response.errors) {
                      // Constrói uma mensagem de erro detalhada
                      $.each(response.errors, function(attribute, errors) {
                          $.each(errors, function(index, error) {
                              errorMsg += '\n' + error;
                          });
                      });
                  } else if (response.message) {
                      errorMsg = response.message;
                  }
                  alert(errorMsg);
              }
          },
          error: function(xhr, status, error) {
              console.error('Erro na solicitação AJAX:', error);
              alert('Erro ao processar a solicitação.');
          }
      });
  });
});

// Função para adicionar o efeito de ripple
function addRippleEffect(e) {
  const target = e.currentTarget;

  // Remove qualquer ripple existente
  const existingRipple = target.querySelector('.ripple::after');
  if (existingRipple) {
    existingRipple.remove();
  }

  // Cria o elemento ripple
  const ripple = document.createElement('span');
  ripple.classList.add('ripple-effect');

  // Calcula a posição do clique
  const rect = target.getBoundingClientRect();
  const size = Math.max(target.clientWidth, target.clientHeight);
  ripple.style.width = ripple.style.height = `${size}px`;
  ripple.style.left = `${e.clientX - rect.left - size / 2}px`;
  ripple.style.top = `${e.clientY - rect.top - size / 2}px`;

  // Adiciona o ripple ao elemento
  target.appendChild(ripple);

  // Remove o ripple após a animação
  ripple.addEventListener('animationend', () => {
    ripple.remove();
  });
}

// Adiciona o listener de evento para todos os botões com a classe 'ripple'
document.querySelectorAll('.ripple').forEach(button => {
  button.addEventListener('click', addRippleEffect);
});

