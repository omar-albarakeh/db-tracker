const apiUrl = '../api/';

document.getElementById('transaction-form').addEventListener('submit', addTransaction);
document.getElementById('fetch-transactions').addEventListener('click', getTransactions);

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
    const userId = 1; // Replace with dynamic user ID if available

    axios.get(apiUrl + 'read.php', {
        params: { userId }
    })
    .then(response => {
        const transactions = response.data;
        displayTransactions(transactions);
    })
    .catch(error => console.error('Error fetching transactions:', error));
}