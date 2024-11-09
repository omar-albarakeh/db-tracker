const apiUrl = '../api/';

document.getElementById('transaction-form').addEventListener('submit', addTransaction);
document.getElementById('fetch-transactions').addEventListener('click', getTransactions);
document.getElementById('apply-filters').addEventListener('click', applyFilters);
document.getElementById('edit-transaction-form').addEventListener('submit', updateTransaction);


function addTransaction(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = {
        notes: formData.get('notes'),
        amount: parseFloat(formData.get('amount')),
        type: formData.get('type'),
    };

    axios.post(apiUrl + 'create.php', data)
        .then(response => {
            alert(response.data.message || 'Transaction added');
            getTransactions();
        })
        .catch(error => console.error('Error adding transaction:', error));
}

function getTransactions() {
    const userId = 1;

    axios.get(apiUrl + 'read.php', {
        params: { userId }
    })
    .then(response => {
        const transactions = response.data;
        displayTransactions(transactions);
    })
    .catch(error => console.error('Error fetching transactions:', error));
}

function applyFilters() {
    const userId = 1;
    const filters = {
        minAmount: document.getElementById('min-amount').value,
        maxAmount: document.getElementById('max-amount').value,
        date: document.getElementById('filter-date').value,
        type: document.getElementById('filter-type').value,
        notes: document.getElementById('filter-notes').value,
    };

    axios.get(apiUrl + 'read.php', {
        params: { userId, ...filters }
    })
    .then(response => displayTransactions(response.data))
    .catch(error => console.error('Error applying filters:', error));
}

function displayTransactions(transactions) {
    const list = document.getElementById('transactions-list');
    list.innerHTML = '';
    transactions.forEach(transaction => {
        const item = document.createElement('div');
        item.innerHTML = `
            <p>${transaction.notes} - $${transaction.amount} (${transaction.type})</p>
            <button onclick="editTransaction(${transaction.id})">Edit</button>
            <button onclick="deleteTransaction(${transaction.id})">Delete</button>
        `;
        list.appendChild(item);
    });
}

function editTransaction(id) {
    axios.get(apiUrl + 'read_single.php', { params: { id } })
        .then(response => {
            const transaction = response.data;
            document.getElementById('edit-id').value = transaction.id;
            document.getElementById('edit-notes').value = transaction.notes;
            document.getElementById('edit-amount').value = transaction.amount;
            document.getElementById('edit-type').value = transaction.type;
            document.getElementById('edit-transaction-form').style.display = 'block';
        })
        .catch(error => console.error('Error fetching transaction:', error));
}

function updateTransaction(event) {
    event.preventDefault();
    const data = {
        id: document.getElementById('edit-id').value,
        notes: document.getElementById('edit-notes').value,
        amount: parseFloat(document.getElementById('edit-amount').value),
        type: document.getElementById('edit-type').value,
    };

    axios.post(apiUrl + 'update.php', data)
        .then(response => {
            alert(response.data.message || 'Transaction updated');
            getTransactions();
            document.getElementById('edit-transaction-form').style.display = 'none';
        })
        .catch(error => console.error('Error updating transaction:', error));
}

function deleteTransaction(id) {
    axios.post(apiUrl + 'delete.php', { id })
        .then(response => {
            alert(response.data.message || 'Transaction deleted');
            getTransactions();
        })
        .catch(error => console.error('Error deleting transaction:', error));
}