<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Midtrans Payment</title>
    <script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous"></script>
</head>
<body>
    <input type="number" id="quantity" />
    <button id="pay-button">Pay!</button>
    <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre> 

    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{$clientKey}}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            let quantity = document.getElementById('quantity').value;
            let data = {
                "quantity": quantity,
                "_token": "{{ csrf_token() }}",
            }
            $.ajax({
                url: '{{route("snap")}}',
                data: data,
                type: 'POST',
                success: function(dataSnapToken) {
                    // SnapToken acquired from previous step
                    snap.pay(dataSnapToken, {
                        // Optional
                        onSuccess: function(result){
                            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        },
                        // Optional
                        onPending: function(result){
                            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        },
                        // Optional
                        onError: function(result){
                            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        }
                    });
                }
            })
        };
    </script>
</body>
</html>