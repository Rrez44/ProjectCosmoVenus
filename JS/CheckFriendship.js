function checkFriendshipStatus(username, friendUsername) {
    return fetch('../php/FriendSystem/CheckFriendship.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'username': username,
            'friend_username': friendUsername
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log('Response from server:', data); // Debug: log the response
            return data;
        })
        .catch(error => {
            console.error('Error:', error);
            return { status: 'error' };
        });
}

// Example usage


function cancelFriendRequest(username, friendUsername) {
    fetch('../php/FriendSystem/CancelRequest.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'friend_username': friendUsername
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log('Response from cancel_friend_request.php:', data);
            alert(data.message);
            if (data.status === 'success') {
                updateButton(username, friendUsername);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}
function acceptFriendRequest(username, friendUsername) {
    fetch('../php/FriendSystem/AcceptFriend.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'friend_username': friendUsername
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            alert(data.message);
            updateButton(username, friendUsername);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}
function unfriend(username, friendUsername) {
    fetch('../php/FriendSystem/RemoveFriend.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'friend_username': friendUsername
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log('Response from remove_friend.php:', data);
            alert(data.message);
            if (data.status === 'success') {
                updateButton(username, friendUsername); // Update the button after unfriending
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}
function updateButton(username, friendUsername) {
    checkFriendshipStatus(username, friendUsername).then(data => {
        const friendActionButton = document.getElementById('friendActionButton');
        const acceptButton = document.getElementById('acceptFriendRequestButton');
        const declineButton = document.getElementById('declineFriendRequestButton');
        const { status, sender_username, receiver_username } = data;

        friendActionButton.style.display = 'none';
        acceptButton.style.display = 'none';
        declineButton.style.display = 'none';

        if (status === 'pending') {
            if (sender_username === username) {
                friendActionButton.textContent = 'Pending';
                friendActionButton.setAttribute('onclick', `cancelFriendRequest('${username}', '${friendUsername}')`);
                friendActionButton.style.display = 'inline';
            } else if (receiver_username === username) {
                acceptButton.style.display = 'inline';
                acceptButton.setAttribute('onclick', `acceptFriendRequest('${username}', '${friendUsername}')`);
                declineButton.style.display = 'inline';
                declineButton.setAttribute('onclick', `declineFriendRequest('${username}', '${friendUsername}')`);
            }
        } else if (status === 'accepted') {
            friendActionButton.textContent = 'Unfriend';
            friendActionButton.setAttribute('onclick', `unfriend('${username}', '${friendUsername}')`);
            friendActionButton.style.display = 'inline';
        } else if (status === 'none' || status === 'declined') {
            friendActionButton.textContent = 'Add Friend';
            friendActionButton.setAttribute('onclick', `sendFriendRequest('${username}', '${friendUsername}')`);
            friendActionButton.style.display = 'inline';
        } else {
            friendActionButton.textContent = 'Error';
            friendActionButton.setAttribute('onclick', '');
            friendActionButton.style.display = 'inline';
        }
    });
}

function declineFriendRequest(username, friendUsername) {
    fetch('../php/FriendSystem/DeclineFriend.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'friend_username': friendUsername
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            alert(data.message);
            updateButton(username, friendUsername); // Update the button after declining
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}