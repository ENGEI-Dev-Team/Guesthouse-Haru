<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新しいお問い合わせ</title>
</head>

<body>
  <h1>新しいお問い合わせがあります</h1>
  <p><strong>名前:</strong> {{ $contact->name }}</p>
  <p><strong>メールアドレス:</strong> {{ $contact->email }}</p>
  <p><strong>メッセージ:</strong> {{ $contact->message }}</p>
</body>

</html>