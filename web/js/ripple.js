document.addEventListener('DOMContentLoaded', () => {
  const rippleElements = document.querySelectorAll('.ripple');

  rippleElements.forEach(elem => {
    elem.addEventListener('click', function(e) {
      // Remove qualquer ripple existente
      const existingRipple = this.querySelector('.ripple-effect');
      if (existingRipple) {
        existingRipple.remove();
      }

      // Cria o elemento ripple
      const ripple = document.createElement('span');
      ripple.classList.add('ripple-effect');

      // Calcula a posição do clique
      const rect = this.getBoundingClientRect();
      const size = Math.max(this.clientWidth, this.clientHeight);
      ripple.style.width = ripple.style.height = `${size}px`;
      ripple.style.left = `${e.clientX - rect.left - size / 2}px`;
      ripple.style.top = `${e.clientY - rect.top - size / 2}px`;

      // Adiciona o ripple ao elemento
      this.appendChild(ripple);

      // Remove o ripple após a animação
      ripple.addEventListener('animationend', () => {
        ripple.remove();
      });
    });
  });

  // Handle row clicks to toggle faturas
  const clickableRows = document.querySelectorAll('.clickable-row');
  clickableRows.forEach(row => {
    row.addEventListener('click', () => {
      const id = row.getAttribute('data-id');
      const faturaRow = document.getElementById(`faturas-${id}`);
      if (faturaRow) {
        faturaRow.style.display = faturaRow.style.display === 'none' ? 'table-row' : 'none';
      }
    });
  });

  // Handle 'copy fatura' button clicks
  const copyButtons = document.querySelectorAll('.btn-copy-fatura');
  copyButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      const faturaId = button.getAttribute('data-id');

      // Fetch fatura data via AJAX (você precisa implementar a ação no controlador)
      fetch(`<?= Url::to(['bancos/get-fatura']) ?>?id=${faturaId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Popula os campos do modal
            document.getElementById('faturaId').value = data.fatura.id;
            document.getElementById('faturaDescricao').value = data.fatura.descricao;
            document.getElementById('faturaData').value = data.fatura.data;
            document.getElementById('faturaValor').value = data.fatura.valor;
            document.getElementById('faturaParcelas').value = data.fatura.parcelas;
            document.getElementById('faturaCategoria').value = data.fatura.categoria;
            document.getElementById('faturaBanco').value = ''; // Reseta o banco selecionado

            // Exibe o modal
            $('#copyFaturaModal').modal('show');
          } else {
            alert('Erro ao obter dados da fatura.');
          }
        })
        .catch(error => {
          console.error('Erro:', error);
          alert('Ocorreu um erro.');
        });
    });
  });

  // Handle copy fatura form submission
  const copyFaturaForm = document.getElementById('copyFaturaForm');
  copyFaturaForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(copyFaturaForm);

    fetch(copyFaturaUrl, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Fatura copiada com sucesso!');
        $('#copyFaturaModal').modal('hide');
        location.reload(); // Recarrega a página para refletir as alterações
      } else {
        alert('Erro ao copiar a fatura.');
      }
    })
    .catch(error => {
      console.error('Erro:', error);
      alert('Ocorreu um erro.');
    });
  });
});
