//---Update the Push Notification Status---
function updatePushNotificationStatus(status) {
    pushNotification.dataset.checked = status;
    if (status) {
        notificationIndicator.classList.remove("fa-bell");
        notificationIndicator.classList.add("fa-bell-slash");
    } else {
        notificationIndicator.classList.remove("fa-bell-slash");
        notificationIndicator.classList.add("fa-bell");
    }
}
      
function checkIfPushIsEnabled() {
    //---check if push notification permission
    // has been denied by the user---
    if (Notification.permission === 'denied') {
        console.log('User has blocked push notification.');
        return;
    }
    //---check if push notification is
    // supported or not---
    if (!('PushManager' in window)) {
        console.log('Sorry, Push notification is not supported on this browser.');
        return;
    }
    //---get push notification subscription
    // if serviceWorker is registered and ready---
    navigator.serviceWorker.ready
    .then(function (registration) {
        registration.pushManager.getSubscription()
        .then(function (subscription) {
            if (subscription) {
                //---user is currently subscribed to push---
                updatePushNotificationStatus(true);
            }
            else {
                //---user is not subscribed to push---
                updatePushNotificationStatus(false);
            }
        })
        .catch(function (error) {
            console.error( 'Error occurred enabling push ', error);
        });
    });
}
      
//---subscribe to push notification---
function subscribeToPushNotification() {
    navigator.serviceWorker.ready
    .then(function(registration) {
        if (!registration.pushManager) {
            console.log( 'This browser does not support push notification.');
            return false;
        }
        //---to subscribe push notification using
        // pushmanager---
        registration.pushManager.subscribe(
            //---always show notification when received---
            { userVisibleOnly: true }
        )
        .then(function (subscription) {
            var endpointSections = subscription.endpoint.split('/');
            var subscriptionId = endpointSections[endpointSections.length - 1];
            var newKey = firebase.database().ref().child('token').push().key;
            firebase.database().ref('token/' + newKey).set(
                {
                    subscriptionId: subscriptionId,
                    userID: userID,
                    customer_type: customer_type
                }
            );

            updatePushNotificationStatus(true);
            console.log('Push notification subscribed.' , subscription);
        })
        .catch(function (error) {
            updatePushNotificationStatus(false);
            console.error( 'Push notification subscription error: ', error);
        });
    })
}
      
//---unsubscribe from push notification---
function unsubscribeFromPushNotification() {
    navigator.serviceWorker.ready
    .then(function(registration) {
        registration.pushManager.getSubscription()
        .then(function (subscription) {
            if(!subscription) {
                console.log('Unable to unsubscribe from push notification.');
                return;
            }
            subscription.unsubscribe()
            .then(function () {
                console.log('Push notification unsubscribed.' , subscription);
                updatePushNotificationStatus(false);
            })
            .catch(function (error) {
                console.error(error);
            });
        })
        .catch(function (error) {
            console.error('Failed to unsubscribe push notification.');
        });
    })
}