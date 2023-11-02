<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        main{
            width: 100%;
            height: 100vh;
            align-items: center;
            display: grid;
            place-items: center;
            margin-top: 100px;
        }
        .flex{
            display: flex;
            width: 300px;
            justify-content: space-between;
        }
        button{
            font-size: 1.5rem
        }
    </style>
</head>
<body>
    <main>
        <div class="startAt">
            <h3>Start Time</h3>
        </div>
        <div class="endAt">
            <h3>End Time</h3>
        </div>
        <div class="flex">
            <button class="timer__start">Start</button>
            <button class="timer__end">End</button>
        </div>
    </main>
    <script>
        const insertStartTime = document.querySelector('.startAt');
        const insertEndTime = document.querySelector('.endAt');
        const timerStart = document.querySelector('.timer__start');
        const timerEnd = document.querySelector('.timer__end');

        const sendTimeToServer = (buttonType) => {
            console.log('hi1');
            const time = new Date(); // スタートボタンが押された時刻を取得
            console.log(time);
            console.log('hi2');

            const postData = {
                buttonType: buttonType,
                timestamp: time.toISOString()
            }

            // startTimeをPHP側に送信
            fetch('server.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(postData)
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                // server.phpからの応答をオブジェクトに変換 (dict型)
                const parsedData = JSON.parse(data);
                if (parsedData['startAt']){
                    insertStartTime.textContent = "Start at: " + parsedData['startAt'];
                } else if (parsedData['endAt']){
                    insertEndTime.textContent = "End at: " + parsedData['endAt'];
                }
                
            })
            .catch(error => {
                // エラー処理
                console.error('エラー:', error);
            });
        };

        timerStart.addEventListener('click', () => {
            sendTimeToServer('start');
        });
        
        timerEnd.addEventListener('click', () => {
            sendTimeToServer('end');
        });
    </script>
</body>
</html>