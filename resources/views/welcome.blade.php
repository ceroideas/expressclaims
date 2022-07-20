<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <script data-ionic="inject">
    (function(w){var i=w.Ionic=w.Ionic||{};i.version='3.3.0';i.angular='4.1.2';i.staticDir='build/';})(window);
  </script>
    <meta charset="UTF-8">
    <title>Ionic App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">

    <link rel="icon" type="image/x-icon" href="assets/icon/favicon.ico">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#4e8ef7">

    <!-- cordova.js required for cordova apps -->
    <script src="cordova.js"></script>

    <!-- un-comment this code to enable service worker
  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('service-worker.js')
        .then(() => console.log('service worker installed'))
        .catch(err => console.log('Error', err));
    }
  </script>-->

    <link href="{{ url('build') }}/main.css" rel="stylesheet">

</head>

<body>

    <!-- Ionic's root component and where the app will load -->
    <ion-app></ion-app>

    <!-- The polyfills js is generated during the build process -->
    <script src="{{ url('build') }}/polyfills.js"></script>

    <script src="https://cloud.apizee.com/apiRTC/apiRTC-latest.min.js"></script>

    <!-- The bundle js is generated during the build process -->
    <script src="{{ url('build') }}/main.js"></script>

</body>

</html>