self.addEventListener("install", () => {
    self.skipWaiting();
});

//listen to push notification
/// listen to push event , aka push messages and display them
self.addEventListener('push', function (event) {

    var payload = event.data ? event.data.text() : 'no payload';
    console.log('Received a push message', payload);
    payload = JSON.parse(payload);

    var title = payload.title;
    var body = payload.body;
    var icon = payload.icon;
    var tag = payload.tag;

    event.waitUntil(
        self.registration.showNotification(title, {
            body: body,
            icon: icon,
            tag: tag
        })
    );
});

// listen to close notification event , try to gain focus on  webapp
self.addEventListener("notificationclick", function (event) {
    console.log(event);
    //To open the app after click notification
    event.waitUntil(
        clients.matchAll({
            type: "window"
        })
            .then(function (clientList) {
                for (var i = 0; i < clientList.length; i++) {
                    var client = clientList[i];
                    if ("focus" in client) {
                        return client.focus();
                    }
                }

                if (clientList.length === 0) {
                    if (clients.openWindow) {
                        return clients.openWindow(event.url);
                    }
                }
            })
    );

    // close the notification
    event.notification.close();
});