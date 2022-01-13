<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">

    <title>{{ config('app.name') }}</title>
</head>
<body>

<div class="container-fluid text-center">
    <h1>{{ config('app.name') }}</h1>
    <div class="d-flex justify-content-center">
        <button id="login-button" onclick="phantomLogin()" class="btn btn-dark">Login with Phantom Wallet</button>
    </div>

    <div class="d-flex justify-content-center ">
        <div class="public-key" style="display: none"></div>
    </div>
</div>

<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/jquery-3.6.0.min.js"></script>

<script>
    async function phantomLogin() {
        const isPhantomInstalled = window.solana && window.solana.isPhantom;
        if (!isPhantomInstalled) {
            alert("Phantom plugin is not detected!");
        } else {
            try {
                const resp = await window.solana.connect();
                console.log('Account: ' + resp.publicKey.toString());
                $('#login-button').hide();
                let publicKeyDiv = $('.public-key');
                publicKeyDiv.html(resp.publicKey.toString());
                publicKeyDiv.show();
            } catch (err) {
                console.log("User rejected request");
            }
        }
    }
</script>

</body>
</html>
