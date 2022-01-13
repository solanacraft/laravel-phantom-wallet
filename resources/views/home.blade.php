<!doctype html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="{{ config('app.name') }}"/>

    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="apple-touch-icon" href="/apple-touch-icon.png"/>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png"/>
</head>
<body>

<div class="container-fluid text-center mt-5">
    <h1>{{ config('app.name') }}</h1>
    <div class="d-flex justify-content-center mt-5">
        <button id="login-button" onclick="phantomLogin()" class="btn btn-dark">Login with Phantom Wallet</button>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div class="public-key" style="display: none"></div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div class="sol-balance" style="display: none">

        </div>
    </div>
</div>

<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/@solana/web3.js@latest/lib/index.iife.min.js"></script>

<script>
    async function phantomLogin() {
        const isPhantomInstalled = window.solana && window.solana.isPhantom;
        if (!isPhantomInstalled) {
            alert("Phantom browser extension is not detected!");
        } else {
            try {
                const resp = await window.solana.connect();
                console.log('Account: ' + resp.publicKey.toString());
                connectAccountAnimation(resp.publicKey.toString());
            } catch (err) {
                console.log("User rejected request");
                console.log(err);
            }
        }
    }

    async function connectAccountAnimation(publicKey) {
        $('#login-button').hide();
        let publicKeyDiv = $('.public-key');
        publicKeyDiv.html('<b>Account:</b> '+publicKey);
        publicKeyDiv.show();
        showBalance();
    }

    async function showBalance(){
        let provider = window.solana;
        let connection = new solanaWeb3.Connection(solanaWeb3.clusterApiUrl('mainnet-beta'), 'confirmed');
        connection.getBalance(provider.publicKey).then(function (value) {
            let solBalanceDiv = $('.sol-balance');
            solBalanceDiv.html('<b>Balance:</b> ' + (value/1000000000) + ' SOL');
            solBalanceDiv.show();
        });
    }

    try {
        window.onload = () => {
            const isPhantomInstalled = window.solana && window.solana.isPhantom;
            if (isPhantomInstalled) {
                window.solana.connect({onlyIfTrusted: true})
                    .then(({publicKey}) => {
                        connectAccountAnimation(publicKey.toString());
                    })
                    .catch(() => {
                        console.log("Not connected");
                    })
            }

        }
    } catch (err) {
        console.log(err);
    }
</script>

</body>
</html>
