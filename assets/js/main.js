const saldoElement = document.getElementById('saldo');
const entradasElement = document.getElementById('entradas');
const saidasElement = document.getElementById('saidas');
const historicoList = document.getElementById('historico-list');
const descricaoInput = document.getElementById('descricao');
const valorInput = document.getElementById('valor');
const dataInput = document.getElementById('data');
const modalOverlay = document.getElementById('modal');
const toggleModalButton = document.getElementById('toggleModal');
const fecharModalButton = document.getElementById('fecharModal');

const transacoes = [];

function atualizarBalanco() {
    fetch('atualizar_balanco.php')
        .then(response => response.json())
        .then(data => {
            saldoElement.textContent = `R$ ${data.saldo.toFixed(2)}`;
            entradasElement.textContent = `R$ ${data.entradas.toFixed(2)}`;
            saidasElement.textContent = `R$ ${data.saidas.toFixed(2)}`;
        })
        .catch(error => console.error('Erro ao atualizar o balanço:', error));
}

atualizarBalanco();


let indiceEdicao = -1; 

function adicionarTransacao() {
    const descricao = descricaoInput.value.trim();
    const valor = parseFloat(valorInput.value);
    const data = dataInput.value;

    if (descricao === '' || isNaN(valor) || data === '') {
        alert('Preencha todos os campos corretamente.');
        return;
    }

    if (indiceEdicao !== -1) {
        const transacaoEditada = {
            descricao,
            valor,
            data,
        };
        transacoes[indiceEdicao] = transacaoEditada;
    } else {
        const transacao = {
            descricao,
            valor,
            data,
        };
        transacoes.push(transacao);
    }

    atualizarHistorico();
    atualizarBalanco();

    limparCampos();
    indiceEdicao = -1;
    fecharModal();
}


function atualizarHistorico(transacao) {
    const listItem = document.createElement('li');
    const valorPrefixo = transacao.valor < 0 ? '-' : '+';
    listItem.innerHTML = `
        <p>${transacao.descricao}</p>
        <p>${valorPrefixo} R$ ${Math.abs(transacao.valor).toFixed(2)}</p>
        <p class="data">${transacao.data}</p>
    `;

    historicoList.appendChild(listItem);
}

function fecharModal() {
    modalOverlay.style.display = 'none';
}

function abrirModal() {
    modalOverlay.style.display = 'flex';
}

function limparCampos() {
    descricaoInput.value = '';
    valorInput.value = '';
    dataInput.value = '';
}

toggleModalButton.addEventListener('click', abrirModal);
fecharModalButton.addEventListener('click', fecharModal);

function criarItemHistorico(transacao) {
    const listItem = document.createElement('li');
    const valorPrefixo = transacao.valor < 0 ? '-' : '+';
    listItem.innerHTML = `
        <p>${transacao.descricao}</p>
        <p>${valorPrefixo} R$ ${Math.abs(transacao.valor).toFixed(2)}</p>
        <p class="data">${transacao.data}</p>
        <button class="editar" data-id="${transacoes.indexOf(transacao)}">Editar</button>
        <button class="excluir" data-id="${transacoes.indexOf(transacao)}">Excluir</button>
        `;

        listItem.querySelector('.editar').addEventListener('click', function() {
            const transacaoId = this.getAttribute('data-id');
            editarTransacao(transacaoId);
        });

    return listItem;
}

function atualizarHistorico() {
    historicoList.innerHTML = '';
    transacoes.forEach(transacao => {
        const listItem = criarItemHistorico(transacao);
        historicoList.appendChild(listItem);
    });

    document.querySelectorAll('.editar').forEach(button => {
        button.addEventListener('click', function() {
            const transacaoId = this.getAttribute('data-id');
            editarTransacao(transacaoId);
        });
    });
    
    document.querySelectorAll('.excluir').forEach(button => {
        button.addEventListener('click', function() {
            const transacaoId = this.getAttribute('data-id');
            confirmarExclusao(transacaoId);
        });
    });
}

function removerTransacao(index) {
    if (index >= 0 && index < transacoes.length) {
        transacoes.splice(index, 1);
        atualizarBalanco();
        atualizarHistorico();
    }
}

atualizarBalanco();

function confirmarExclusao(index) {
    const modalConfirmarExclusao = document.getElementById('modalConfirmarExclusao');
    const confirmarExcluirNotaButton = document.getElementById('confirmarExcluirNota');
    const cancelarExcluirNotaButton = document.getElementById('cancelarExcluirNota');

    modalConfirmarExclusao.style.display = 'flex';

    confirmarExcluirNotaButton.onclick = function () {
        removerTransacao(index);
        modalConfirmarExclusao.style.display = 'none';
    };

    cancelarExcluirNotaButton.onclick = function () {
        modalConfirmarExclusao.style.display = 'none';
    };
}

function editarTransacao(index) {
    const transacao = transacoes[index];

    descricaoInput.value = transacao.descricao;
    valorInput.value = transacao.valor;
    dataInput.value = transacao.data;

    indiceEdicao = index;

    abrirModal();
}
