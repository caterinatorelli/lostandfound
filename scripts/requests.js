function requestAction(approve, id) {
    const params = {
        approved: approve,
        objectID: id
    };

    const options = {
        method: 'POST',
        headers : {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    };

    fetch('http://127.0.0.1/lostandfound/revision-api.php', options)
        .then(response => response.json())
        .then( data => {
            location.reload();
        });
}