require('offline-plugin/runtime').install();
import axios from 'axios'

/// make axis global so we can use it every where 
window.axios = axios

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

/// get browser's end point 
if ('serviceWorker' in navigator && "Notification" in window) {
    Notification.requestPermission().then(function (result) {
        if (result == "granted") {
            navigator.serviceWorker.getRegistration()
                .then(function (registration) {
                    return registration.pushManager.getSubscription()
                        .then(function (subscription) {
                            if (subscription) {
                                return subscription;
                            }
                            return registration.pushManager.subscribe({
                                userVisibleOnly: true,
                                applicationServerKey: new urlBase64ToUint8Array('BGisx88cLlx83WZ1Yc/V/2U+4G4/g2u9aeoUaUKSd1L+cCTF/4ow5xGWvLCZTPZav92/wkr6r9h2OyKgcWb6s5c=')
                            });
                        });
                }).then(function (subscription) {

                    const endpoint = subscription.endpoint;
                    const rawKey = subscription.getKey('p256dh');
                    const rawToken =  subscription.getKey('auth');
                    const key =  rawKey ? btoa(String.fromCharCode.apply(null, new Uint8Array(rawKey))) : null;
                    const token =  rawToken ? btoa(String.fromCharCode.apply(null, new Uint8Array(rawToken))) : null;
                    console.log(subscription.toJSON());
                    console.log(rawKey,token);

                    axios.post('/notification/register', { 'endpoint': endpoint , 'key' : key , 'authSecret' : token})
                        .then(function (response) {
                            if (response.data.new) {
                                new Notification("Thank you for enabling notification", {
                                    body: "We won't spam you , we promise",
                                    tag: "success",
                                    icon: "https://cdn1.iconfinder.com/data/icons/twitter-ui-colored/48/JD-24-128.png"
                                });
                            }
                        })
                        .catch(function (error) {
                            alert("we can't save your endpoint");
                            console.log(error);
                        });
                });
        }
    });
}