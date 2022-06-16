$('#updateNameForm').on('submit', updateName);
$('#updateEmailForm').on('submit', updateEmail);
$('#updatePasswordForm').on('submit', updatePassword);
$('#updateInformationForm').on('submit', updateInformation);
$('#deleteForm').on('submit', deleteAccount);

$('form button').on('click', close)

async function updateName(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updateNameBtn', true);

    try {
        const response = await fetch('../src/app/API.php', {
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

async function updateEmail(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updateEmailBtn', true);

    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        if(data['message'].includes("success")) {
            window.location.replace("myPage.php?emailUpdated");
        } else {
            $('.formMessage').html(data['message']);
        }
        
} catch(error) {
        console.log(error);
    }
}

async function updatePassword(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updatePasswordBtn', true);

    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        if(data['message'].includes("success")) {
            window.location.replace("myPage.php?passwordUpdated");
        } else {
            $('.formMessage').html(data['message']);
        }
        
} catch(error) {
        console.log(error);
    }
}

async function updateInformation(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updateInformationBtn', true);

    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        if(data['message'].includes("success")) {
            window.location.replace("myPage.php?informationUpdated");
        } else {
            $('.formMessage').html(data['message']);
        }
        
} catch(error) {
        console.log(error);
    }
}

async function deleteAccount(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('deleteBtn', true);

    try {
        await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        window.location.replace("login.php?deleted");
        
    } catch(error) {
            console.log(error);
        }
}

function close() {
    window.location.replace("myPage.php");
}