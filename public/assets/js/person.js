console.log("JS carregado com sucesso!");


// mock do fetch()
const persons = [
    {
        id: 1,
        name: 'thiago',
        email: 'thiago@gmail.com'
    },
    {
        id: 2,
        name: 'diego',
        email: 'diego@gmail.com'
    },
    {
        id: 3,
        name: 'josiel',
        email: 'josiel@gmail.com'
    }
];






document.addEventListener("DOMContentLoaded", () => {
    const filterInput = document.querySelector('#filter');
    const tableBody = document.querySelector('#table-body');

    function renderTable(data) {
        tableBody.innerHTML = "";

        const filteredPersons = persons.filter(person => {
            const term =  data.toLocaleLowerCase();

            return (
                person.name.toLocaleLowerCase().includes(term) ||
                person.email.toLocaleLowerCase().includes(term)
            )
        })

        filteredPersons.forEach(person => {
            const row = document.createElement("tr");// cria linha
            row.innerHTML = `
                <td>${person.id}</td> 
                <td>${person.name}</td>
                <td>${person.email}</td>
            `;// adiciona colunas
            tableBody.appendChild(row) //adicionar as linhas com colunas na tabela
        });
    }

    async function reloadPersons(filter = '') {
        renderTable(filter)
    }

    // executa quando algum valor no input é inserido/alterado
    filterInput.addEventListener("input", () => {
        reloadPersons(filterInput.value);
    })

    // executa assim que carregar o conteúdo html
    reloadPersons();
});