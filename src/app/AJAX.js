$('#updateNameForm').on('submit', updateName);

async function updateName(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    // console.log(formData.get('firstname'));
    // console.log(formData.get('lastname'));
    formData.set('updateNameBtn', true);
    // console.log(formData);

    try {
        const response = await fetch('../src/app/nameAPI.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        console.log(data);
        
    //     $('#form-message').html(data['message']);
    //     appendPunList(data['puns']);
} catch(error) {
        console.log(error);
    }
}