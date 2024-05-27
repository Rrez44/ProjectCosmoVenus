function sendFriendRequest(username, friendUsername) {
    fetch('../php/FriendSystem/AddFriend.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'username': username,
            'friend_username': friendUsername
        })
    })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            alert(data);
            updateButton(username, friendUsername);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}
