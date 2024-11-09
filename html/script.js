const apiUrl = '../api/';

document.getElementById('transaction-form').addEventListener('submit', addTransaction);

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

