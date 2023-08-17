<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
    <a href="{{ route('post.index') }}">戻る</a>
  <form action="" method="POST">
    @csrf
    <div>
    <label for="">タイトル</label>
    <input type="text" name="title">
</div>
<div>
    <label for="">本文</label>
    <textarea name="content" id="" cols="30" rows="10"></textarea>
</div>
<div>
    <label for="">タグ(複数の場合空白で区切ること)</label>
    <input type="text" name="tags">
</div>
  </form>
</body>
</html>
