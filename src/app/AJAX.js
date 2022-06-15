$('#updateNameForm').on('submit', updateName);

async function updateName(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updateNameBtn', true);

    try {
        const response = await fetch('../src/app/nameAPI.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        if(data['message'].includes("success")) {
            window.location.replace("myPage.php?nameUpdated");
        } else {
            $('.formMessage').html(data['message']);
        }
        
} catch(error) {
        console.log(error);
    }
}